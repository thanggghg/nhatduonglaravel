<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class NhatDuongPublicBookingService
{
    public function createOrder(array $payload, string $idempotencyKey): array
    {
        if ($idempotencyKey === '') {
            throw new RuntimeException('A Public Booking API idempotency key is required.');
        }

        $response = $this->post('/orders', $payload, ['Idempotency-Key' => $idempotencyKey]);
        if (!in_array($response['status_code'], [200, 201], true)) {
            throw new RuntimeException('Public Booking API returned an unexpected create-order response.');
        }

        return $this->validateOrderResponse($response['body'], 'PENDING_PAYMENT', true);
    }

    public function pay(string $orderId, string $paymentReference): array
    {
        if ($orderId === '' || $paymentReference === '') {
            throw new RuntimeException('A Public Booking API order ID and payment reference are required.');
        }

        $response = $this->post('/orders/'.rawurlencode($orderId).'/pay', [
            'paymentReference' => $paymentReference,
        ]);
        if ($response['status_code'] !== 200) {
            throw new RuntimeException('Public Booking API returned an unexpected payment response.');
        }

        return $this->validateOrderResponse($response['body'], 'PAID', false);
    }

    private function post(string $path, array $payload, array $headers = []): array
    {
        [$baseUrl, $apiKey] = $this->configuration();

        try {
            $response = Http::acceptJson()
                ->asJson()
                ->withHeaders(['X-Internal-Booking-Key' => $apiKey] + $headers)
                ->connectTimeout(5)
                ->timeout(15)
                // Connection retries reuse the caller's idempotency key and original body.
                ->retry(2, 250, fn (\Throwable $exception) => $exception instanceof ConnectionException, false)
                ->post($baseUrl.$path, $payload);
        } catch (ConnectionException) {
            throw new RuntimeException('Public Booking API could not be reached. Please try again later.');
        }

        if (!$response->successful()) {
            throw new RuntimeException('Public Booking API request failed with HTTP status '.$response->status().'.');
        }

        $body = $response->json();
        if (!is_array($body)) {
            throw new RuntimeException('Public Booking API returned an invalid response.');
        }

        return ['status_code' => $response->status(), 'body' => $body];
    }

    private function configuration(): array
    {
        $baseUrl = rtrim((string) config('services.public_booking.base_url'), '/');
        $apiKey = (string) config('services.public_booking.api_key');

        if ($baseUrl === '' || $apiKey === '') {
            throw new RuntimeException('Public Booking API is not configured.');
        }

        if (parse_url($baseUrl, PHP_URL_SCHEME) !== 'https') {
            throw new RuntimeException('Public Booking API base URL must use HTTPS.');
        }

        return [$baseUrl, $apiKey];
    }

    private function validateOrderResponse(array $response, string $expectedStatus, bool $expectedPaymentRequired): array
    {
        $orderId = $response['orderId'] ?? null;
        $amount = $response['amount'] ?? null;
        $currency = $response['currency'] ?? null;
        $ticketCodes = $response['ticketCodes'] ?? null;
        $bookingCodes = $response['bookingCodes'] ?? null;

        if (!is_scalar($orderId) || (string) $orderId === '' || !is_numeric($amount) || (int) $amount < 0
            || !is_string($currency) || strlen($currency) !== 3 || !is_array($ticketCodes) || !is_array($bookingCodes)
            || !is_bool($response['paymentRequired'] ?? null)) {
            throw new RuntimeException('Public Booking API returned an incomplete order response.');
        }

        if (($response['status'] ?? null) !== $expectedStatus || $response['paymentRequired'] !== $expectedPaymentRequired) {
            throw new RuntimeException('Public Booking API returned unexpected order status.');
        }

        return [
            'order_id' => (string) $orderId,
            'status' => $response['status'],
            'amount' => (int) $amount,
            'currency' => strtoupper($currency),
            'ticket_codes' => array_values($ticketCodes),
            'booking_codes' => array_values($bookingCodes),
            'payment_required' => $response['paymentRequired'],
        ];
    }
}
