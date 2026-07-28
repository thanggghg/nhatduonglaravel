<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\SePayService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct(private SePayService $sepay)
    {
    }

    public function show(Booking $booking)
    {
        if ($booking->payment_status === 'paid') {
            return redirect()->route('booking.success', ['booking' => $booking, 'lang' => $booking->locale]);
        }

        if ($booking->public_booking_idempotency_key && !$booking->public_booking_order_id) {
            abort(409, 'This live booking is not ready for payment.');
        }

        $booking->load(['route', 'schedule', 'returnSchedule']);

        try {
            $payment = $this->sepay->paymentDetails($booking);
            $paymentError = null;
        } catch (\Throwable $exception) {
            report($exception);
            $payment = null;
            $paymentError = true;
        }

        return view('booking.payment', compact('booking', 'payment', 'paymentError'));
    }

    public function check(Booking $booking)
    {
        try {
            $paid = $this->sepay->reconcile($booking);
        } catch (\Throwable $exception) {
            report($exception);

            return back()->with('payment_error', 'Unable to verify the payment right now.');
        }

        if (!$paid) {
            return back()->with('payment_pending', 'Payment has not been received yet. Please try again shortly.');
        }

        return redirect()->route('booking.success', ['booking' => $booking, 'lang' => $booking->locale]);
    }

    public function status(Booking $booking): JsonResponse
    {
        return response()->json([
            'paid' => $booking->payment_status === 'paid',
            'success_url' => route('booking.success', ['booking' => $booking, 'lang' => $booking->locale]),
        ]);
    }

    public function webhook(Request $request): JsonResponse
    {
        $secret = config('services.sepay.webhook_secret');
        $authorization = (string) $request->header('Authorization');
        $providedSecret = (string) $request->header('X-Secret-Key');
        if (str_starts_with($authorization, 'Apikey ')) {
            $providedSecret = trim(substr($authorization, 7));
        }

        if (!$secret || !hash_equals($secret, $providedSecret)) {
            return response()->json(['success' => false], 401);
        }

        $payload = $request->json()->all();
        $code = strtoupper((string) ($payload['code'] ?? ''));
        if (!$code && preg_match('/\bND[A-Z0-9]{8}\b/i', (string) ($payload['content'] ?? ''), $matches)) {
            $code = strtoupper($matches[0]);
        }
        $booking = Booking::where('payment_code', $code)->first();

        if (!$booking || ($payload['transferType'] ?? null) !== 'in' || (int) ($payload['transferAmount'] ?? 0) !== $booking->total_amount) {
            Log::warning('Ignored SePay payment webhook.', ['payment_code' => $code]);

            return response()->json(['success' => true]);
        }

        try {
            $this->sepay->markPaid($booking, $payload);
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json(['success' => false], 503);
        }

        return response()->json(['success' => true]);
    }
}
