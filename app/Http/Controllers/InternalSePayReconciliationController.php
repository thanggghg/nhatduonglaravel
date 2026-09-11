<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\SePayService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class InternalSePayReconciliationController extends Controller
{
    public function __construct(private SePayService $sepay)
    {
    }

    public function index(Request $request): JsonResponse
    {
        if ($response = $this->authorizeRequest($request)) {
            return $response;
        }

        $bookings = Booking::query()
            ->whereNotNull('public_booking_order_id')
            ->where('payment_status', '!=', 'paid')
            ->whereNotIn('status', ['failed', 'cancelled'])
            ->latest()
            ->limit(100)
            ->get();
        $usedTransactions = Booking::query()
            ->whereNotNull('payment_transaction_id')
            ->get(['id', 'reference', 'payment_transaction_id', 'payment_reference'])
            ->flatMap(fn (Booking $booking) => array_filter([
                (string) $booking->payment_transaction_id => $booking,
                (string) $booking->payment_reference => $booking,
            ]));

        $sepayTransactions = collect($this->sepay->transactions());
        $resolutions = DB::table('sepay_transaction_resolutions')
            ->whereIn('transaction_id', $sepayTransactions->pluck('id')->filter())
            ->get()
            ->keyBy('transaction_id');
        $transactions = $sepayTransactions
            ->map(function (array $transaction) use ($bookings, $usedTransactions, $resolutions) {
                $id = (string) ($transaction['id'] ?? '');
                $reference = (string) ($transaction['reference_number'] ?? $transaction['referenceCode'] ?? '');
                $amount = (int) ($transaction['amount_in'] ?? 0);
                $content = (string) ($transaction['transaction_content'] ?? $transaction['content'] ?? '');
                $matched = $usedTransactions->get($id) ?? $usedTransactions->get($reference);
                $resolution = $resolutions->get($id);
                $candidates = $bookings->filter(fn (Booking $booking) => $booking->total_amount === $amount);
                $suggested = $bookings->first(fn (Booking $booking) => str_contains(strtoupper($content), $booking->payment_code));
                if (!$suggested && $candidates->count() === 1) {
                    $suggested = $candidates->first();
                }

                return [
                    'id' => $id,
                    'reference' => $reference,
                    'transactionDate' => $transaction['transaction_date'] ?? null,
                    'amount' => $amount,
                    'content' => $content,
                    'bankBrandName' => $transaction['bank_brand_name'] ?? null,
                    'accountNumber' => $transaction['account_number'] ?? null,
                    'matchedBooking' => $matched ? $this->bookingData($matched) : null,
                    'suggestedBookingReference' => $suggested?->reference,
                    'orphan' => !$matched && !$resolution,
                    'manualResolution' => $resolution ? [
                        'status' => $resolution->status,
                        'matchedReference' => $resolution->matched_reference,
                        'resolvedBy' => $resolution->resolved_by,
                        'resolvedAt' => $resolution->resolved_at,
                    ] : null,
                ];
            })
            ->values();

        return response()->json([
            'transactions' => $transactions,
            'unpaidBookings' => $bookings->map(fn (Booking $booking) => $this->bookingData($booking))->values(),
        ]);
    }

    public function match(Request $request): JsonResponse
    {
        if ($response = $this->authorizeRequest($request)) {
            return $response;
        }

        try {
            $context = $this->prepareMatch($request);
            $bookings = DB::transaction(function () use ($context, $request) {
                $bookings = Booking::query()->whereIn('reference', $context['bookingReferences'])->lockForUpdate()->get();
                foreach ($bookings as $booking) {
                    if ($booking->payment_status !== 'paid') {
                        $this->sepay->markPaid($booking, $context['transaction']);
                    }
                }

                $transaction = $context['transaction'];
                $transactionId = (string) ($transaction['id'] ?? '');
                $matchedReferences = array_values(array_unique([
                    ...$context['bookingReferences'],
                    ...$context['externalReferences'],
                ]));
                $now = now();
                DB::table('sepay_transaction_resolutions')->updateOrInsert(
                    ['transaction_id' => $transactionId],
                    [
                        'status' => 'matched_externally',
                        'matched_reference' => implode(', ', $matchedReferences),
                        'resolved_by' => substr((string) $request->header('X-Actor', 'system'), 0, 100),
                        'resolved_at' => $now,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );

                return $bookings->map(fn (Booking $booking) => $this->bookingData($booking->fresh()))->values();
            });
        } catch (RuntimeException $exception) {
            return response()->json(['message' => $exception->getMessage()], 409);
        }

        return response()->json([
            'message' => 'Đã khớp giao dịch và thanh toán các đơn thành công.',
            'bookings' => $bookings,
        ]);
    }

    public function validateMatch(Request $request): JsonResponse
    {
        if ($response = $this->authorizeRequest($request)) {
            return $response;
        }

        try {
            $context = $this->prepareMatch($request);
        } catch (RuntimeException $exception) {
            return response()->json(['message' => $exception->getMessage()], 409);
        }

        return response()->json([
            'valid' => true,
            'transactionId' => (string) ($context['transaction']['id'] ?? ''),
            'amount' => (int) ($context['transaction']['amount_in'] ?? 0),
        ]);
    }

    public function transaction(Request $request, string $transactionId): JsonResponse
    {
        if ($response = $this->authorizeRequest($request)) {
            return $response;
        }

        $transaction = $this->sepay->findTransaction($transactionId);
        if (!$transaction) {
            return response()->json(['message' => 'Không tìm thấy giao dịch vào trên SePay.'], 404);
        }
        $id = (string) ($transaction['id'] ?? '');
        $reference = (string) ($transaction['reference_number'] ?? $transaction['referenceCode'] ?? '');

        return response()->json([
            'id' => $id,
            'reference' => $reference,
            'amount' => (int) ($transaction['amount_in'] ?? 0),
            'content' => (string) ($transaction['transaction_content'] ?? $transaction['content'] ?? ''),
            'transactionDate' => $transaction['transaction_date'] ?? null,
        ]);
    }

    public function resolve(Request $request): JsonResponse
    {
        if ($response = $this->authorizeRequest($request)) {
            return $response;
        }

        $validated = $request->validate([
            'transactionId' => ['required', 'string', 'max:100'],
            'matchedReference' => ['nullable', 'string', 'max:100'],
        ]);
        if (Booking::query()->where('payment_transaction_id', $validated['transactionId'])->exists()) {
            return response()->json(['message' => 'Giao dịch đã được khớp với một booking.'], 409);
        }

        $now = now();
        DB::table('sepay_transaction_resolutions')->updateOrInsert(
            ['transaction_id' => $validated['transactionId']],
            [
                'status' => filled($validated['matchedReference'] ?? null) ? 'matched_externally' : 'resolved_manually',
                'matched_reference' => $validated['matchedReference'] ?? null,
                'resolved_by' => substr((string) $request->header('X-Actor', 'admin'), 0, 100),
                'resolved_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        return response()->json(['message' => 'Đã đánh dấu giao dịch không còn mồ côi.']);
    }

    private function prepareMatch(Request $request): array
    {
        $validated = $request->validate([
            'transactionId' => ['required', 'string', 'max:100'],
            'bookingReference' => ['nullable', 'string', 'max:30'],
            'bookingReferences' => ['nullable', 'array', 'max:10'],
            'bookingReferences.*' => ['required', 'string', 'max:30'],
            'externalAmount' => ['nullable', 'numeric', 'min:0'],
            'externalReferences' => ['nullable', 'array', 'max:10'],
            'externalReferences.*' => ['required', 'string', 'max:100'],
        ]);
        $bookingReferences = array_values(array_unique(array_filter([
            ...($validated['bookingReferences'] ?? []),
            $validated['bookingReference'] ?? null,
        ])));
        $externalReferences = array_values(array_unique($validated['externalReferences'] ?? []));
        if (!$bookingReferences && !$externalReferences) {
            throw new RuntimeException('Cần chọn ít nhất một đơn để khớp.');
        }
        if (count($bookingReferences) + count($externalReferences) > 2) {
            throw new RuntimeException('Chỉ được chọn tối đa hai đơn cho một giao dịch.');
        }

        $transaction = $this->sepay->findTransaction($validated['transactionId']);
        if (!$transaction) {
            throw new RuntimeException('Không tìm thấy giao dịch vào trên SePay.');
        }
        $transactionId = (string) ($transaction['id'] ?? '');
        $paymentReference = (string) ($transaction['reference_number'] ?? $transaction['referenceCode'] ?? $transactionId);
        $bookings = Booking::query()->whereIn('reference', $bookingReferences)->get();
        if ($bookings->count() !== count($bookingReferences)) {
            throw new RuntimeException('Không tìm thấy đầy đủ đơn đặt vé website đã chọn.');
        }

        foreach ($bookings as $booking) {
            if ($booking->payment_status === 'paid') {
                if ($booking->payment_transaction_id !== $transactionId && $booking->payment_reference !== $paymentReference) {
                    throw new RuntimeException("Đơn {$booking->reference} đã thanh toán bằng giao dịch khác.");
                }
                continue;
            }
            if (!$booking->public_booking_order_id || in_array($booking->status, ['failed', 'cancelled'], true)) {
                throw new RuntimeException("Đơn {$booking->reference} không còn đủ điều kiện thanh toán.");
            }
        }

        $alreadyUsed = Booking::query()
            ->whereNotIn('reference', $bookingReferences)
            ->where(fn ($query) => $query->where('payment_transaction_id', $transactionId)
                ->orWhere('payment_reference', $paymentReference))
            ->exists();
        if ($alreadyUsed) {
            throw new RuntimeException('Giao dịch này đã được khớp với đơn khác ngoài danh sách đã chọn.');
        }

        $expectedAmount = (int) $bookings->sum('total_amount') + (int) ($validated['externalAmount'] ?? 0);
        if ((int) ($transaction['amount_in'] ?? 0) !== $expectedAmount) {
            throw new RuntimeException('Tổng tiền các đơn đã chọn không bằng số tiền giao dịch.');
        }

        return compact('transaction', 'bookingReferences', 'externalReferences');
    }

    private function authorizeRequest(Request $request): ?JsonResponse
    {
        $expected = (string) config('services.public_booking.api_key');
        $supplied = (string) $request->header('X-Internal-Booking-Key');
        if ($expected === '' || $supplied === '' || !hash_equals($expected, $supplied)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return null;
    }

    private function bookingData(Booking $booking): array
    {
        return [
            'reference' => $booking->reference,
            'paymentCode' => $booking->payment_code,
            'amount' => $booking->total_amount,
            'passengerName' => $booking->passenger_name,
            'passengerPhone' => $booking->passenger_phone,
            'publicBookingOrderId' => $booking->public_booking_order_id,
            'status' => $booking->status,
            'paymentStatus' => $booking->payment_status,
            'createdAt' => $booking->created_at,
        ];
    }
}
