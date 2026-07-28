<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class SePayService
{
    public function __construct(private NhatDuongPublicBookingService $publicBooking)
    {
    }

    public function paymentDetails(Booking $booking): array
    {
        $account = collect($this->bankAccounts())->first(fn (array $account) => (bool) ($account['active'] ?? false));

        if (!$account) {
            throw new RuntimeException('No active SePay payment account is configured.');
        }

        $query = http_build_query([
            'acc' => $account['account_number'],
            'bank' => $account['bank_bin'] ?? $account['bank_short_name'],
            'amount' => $booking->total_amount,
            'des' => $booking->payment_code,
            'template' => 'compact',
            'showinfo' => 'true',
            'fullacc' => 'true',
            'holder' => $account['account_holder_name'],
        ]);

        return [
            'account_name' => $account['account_holder_name'],
            'account_number' => $account['account_number'],
            'bank_name' => $account['bank_full_name'] ?? $account['bank_short_name'],
            'qr_url' => 'https://vietqr.app/img?'.$query,
        ];
    }

    public function reconcile(Booking $booking): bool
    {
        if ($booking->payment_status === 'paid') {
            return true;
        }

        $transactions = $this->request('/v2/transactions', [
            'q' => $booking->payment_code,
            'transfer_type' => 'in',
            'amount_in_min' => $booking->total_amount,
            'per_page' => 100,
        ]);

        $transaction = collect($transactions)->first(function (array $transaction) use ($booking) {
            return (int) ($transaction['amount_in'] ?? 0) === $booking->total_amount
                && str_contains(strtoupper(($transaction['code'] ?? '').' '.($transaction['transaction_content'] ?? '')), $booking->payment_code);
        });

        if (!$transaction) {
            return false;
        }

        $this->markPaid($booking, $transaction);

        return true;
    }

    public function markPaid(Booking $booking, array $transaction): void
    {
        DB::transaction(function () use ($booking, $transaction) {
            $booking = Booking::lockForUpdate()->findOrFail($booking->id);
            if ($booking->payment_status === 'paid') {
                return;
            }

            $paymentReference = (string) ($transaction['reference_number'] ?? $transaction['referenceCode'] ?? $transaction['id'] ?? '');
            if ($booking->public_booking_order_id && $paymentReference === '') {
                throw new RuntimeException('The verified SePay transaction has no provider payment reference.');
            }

            $externalOrder = null;
            if ($booking->public_booking_order_id) {
                // Do not mark the local booking paid until VeXeRe payment succeeds.
                $externalOrder = $this->publicBooking->pay($booking->public_booking_order_id, $paymentReference);
            }

            $updates = [
                'status' => 'confirmed',
                'payment_status' => 'paid',
                'payment_provider' => 'sepay',
                'payment_transaction_id' => (string) ($transaction['id'] ?? $transaction['referenceCode'] ?? ''),
                'payment_reference' => $paymentReference,
                'payment_payload' => $transaction,
                'paid_at' => now(),
            ];
            if ($externalOrder) {
                $updates += [
                    'public_booking_status' => $externalOrder['status'],
                    'public_booking_ticket_codes' => $externalOrder['ticket_codes'],
                    'public_booking_codes' => $externalOrder['booking_codes'],
                ];
            }

            $booking->update($updates);
        });
    }

    private function bankAccounts(): array
    {
        return Cache::remember('sepay.bank_accounts', now()->addMinutes(10), function () {
            return $this->request('/v2/bank-accounts', ['actives' => 1, 'per_page' => 100]);
        });
    }

    private function request(string $path, array $query = []): array
    {
        $token = config('services.sepay.api_token');
        if (!$token) {
            throw new RuntimeException('SePay sandbox API is not configured.');
        }

        $response = Http::acceptJson()
            ->withToken($token)
            ->timeout(15)
            ->get(rtrim(config('services.sepay.base_url'), '/').$path, $query);

        if (!$response->successful()) {
            throw new RuntimeException('SePay sandbox is temporarily unavailable.');
        }

        return $response->json('data', []);
    }
}
