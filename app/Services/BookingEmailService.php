<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class BookingEmailService
{
    public function sendConfirmation(Booking $booking, string $sourceUrl): void
    {
        $apiKey = config('services.smtp2go.api_key');
        $cc = config('services.smtp2go.cc', []);
        $customerEmail = $booking->passenger_email;
        $to = $customerEmail ? [$customerEmail] : array_slice($cc, 0, 1);

        if (!$apiKey || !$to) {
            return;
        }

        if (!$customerEmail) {
            $cc = array_slice($cc, 1);
        } else {
            $cc = array_values(array_diff($cc, [$customerEmail]));
        }

        if (!filter_var($sourceUrl, FILTER_VALIDATE_URL) || !in_array(parse_url($sourceUrl, PHP_URL_SCHEME), ['http', 'https'], true)) {
            $sourceUrl = route('home');
        }

        $booking->loadMissing('route');
        $html = view('emails.booking-confirmation', compact('booking', 'sourceUrl'))->render();
        $paymentMethod = $booking->payment_provider === 'cash' ? 'Tiền mặt khi lên xe' : 'Chuyển khoản ngân hàng';
        $text = implode("\n", [
            'Có 1 đặt vé mới:',
            '- Mã đặt vé: '.$booking->reference,
            '- Ghế/phòng: '.implode(', ', $booking->selected_seats ?? []),
            '- Mã chuyến: '.$booking->trip_code,
            '- Ngày giờ: '.optional($booking->departure_at)->format('d/m/Y H:i'),
            '- Tuyến: '.($booking->route?->from_location ?? '').' - '.($booking->route?->to_location ?? ''),
            '- Khách hàng: '.$booking->passenger_name,
            '- Điện thoại: '.$booking->passenger_phone,
            '- Email: '.$booking->passenger_email,
            '- Điểm đón: '.$booking->pickup_point,
            '- Điểm trả: '.$booking->dropoff_point,
            '- Thanh toán: '.$paymentMethod,
            '- Tổng tiền: '.number_format($booking->total_amount).' VND',
            '- Ghi chú: '.$booking->notes,
            '- Nguồn: '.$sourceUrl,
        ]);

        $response = Http::asJson()
            ->timeout(15)
            ->retry(2, 300)
            ->post('https://api.smtp2go.com/v3/email/send', [
                'api_key' => $apiKey,
                'to' => $to,
                'cc' => $cc,
                'sender' => config('services.smtp2go.sender'),
                'subject' => '[Nhật Dương] Xác nhận đặt vé '.$booking->reference,
                'text_body' => $text,
                'html_body' => $html,
            ]);

        if (!$response->successful() || (int) data_get($response->json(), 'data.succeeded', 0) < 1) {
            throw new RuntimeException('SMTP2GO rejected booking confirmation: '.$response->status());
        }
    }
}
