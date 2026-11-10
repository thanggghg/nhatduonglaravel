<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Route as BusRoute;
use App\Services\BookingEmailService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AdsBookingEmailTest extends TestCase
{
    public function test_ads_confirmation_is_sent_only_to_customer_and_ads_recipient(): void
    {
        config([
            'services.smtp2go.api_key' => 'test-key',
            'services.smtp2go.sender' => 'sender@example.com',
            'services.smtp2go.ads_recipients' => ['t0972199672@gmail.com'],
            'services.smtp2go.cc' => ['other@example.com'],
        ]);
        Http::fake([
            'api.smtp2go.com/v3/email/send' => Http::response(['data' => ['succeeded' => 2]]),
        ]);

        $booking = new Booking([
            'reference' => 'ND-TEST-ADS',
            'trip_code' => 'TRIP-1',
            'departure_at' => Carbon::parse('2026-11-10 20:00:00'),
            'passenger_name' => 'Ads Customer',
            'passenger_email' => 'customer@example.com',
            'passenger_phone' => '0900000000',
            'pickup_point' => 'Nha Trang',
            'dropoff_point' => 'Sai Gon',
            'selected_seats' => ['A01'],
            'total_amount' => 350000,
            'payment_provider' => 'sepay',
            'ads_mode' => true,
        ]);
        $booking->setRelation('route', new BusRoute([
            'from_location' => 'Nha Trang',
            'to_location' => 'Sai Gon',
        ]));

        app(BookingEmailService::class)->sendConfirmation($booking, 'https://nhaxenhatduong.com/', true);

        Http::assertSent(function ($request): bool {
            $payload = $request->data();

            return $payload['to'] === ['customer@example.com', 't0972199672@gmail.com']
                && $payload['cc'] === []
                && $payload['subject'] === '[Nhật Dương] Xác nhận đặt vé ND-TEST-ADS';
        });
    }
}
