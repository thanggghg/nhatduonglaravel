<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Route as BusRoute;
use App\Models\Setting;
use App\Services\BookingEmailService;
use App\Services\NhatDuongPublicBookingService;
use App\Services\VexereTripService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class AdsBookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_ads_booking_skips_external_order_and_local_seat_reservation(): void
    {
        Setting::where('key', 'ads_booking_mode')->update(['value' => '1']);
        $route = BusRoute::create([
            'name' => 'Nha Trang - Sai Gon',
            'slug' => 'nha-trang-sai-gon',
            'from_location' => 'Nha Trang',
            'to_location' => 'Sai Gon',
            'status' => true,
        ]);

        $tripDetails = [
            'trip' => [
                'code' => 'TRIP-ADS-1',
                'available_seats' => 1,
                'departure' => Carbon::parse('2026-11-10 20:00:00'),
                'arrival' => Carbon::parse('2026-11-11 06:00:00'),
                'provider_trip_departure' => Carbon::parse('2026-11-10 20:00:00'),
                'vehicle_type' => 'Limousine',
                'booking_from_id' => 1,
                'booking_to_id' => 2,
            ],
            'coaches' => [[
                'seats' => [[
                    'key' => 'A01',
                    'seat_type' => 1,
                    'available' => true,
                    'locked' => false,
                    'room_options' => [[
                        'id' => 10,
                        'code' => 'ROOM-1',
                        'name' => 'Single room',
                        'customer_amount' => 1,
                        'fare' => 350000,
                    ]],
                ]],
            ]],
            'pickup_points' => [[
                'key' => 'pickup-1',
                'name' => 'Van phong Nha Trang',
                'address' => 'Nha Trang',
                'provider_name' => 'Van phong Nha Trang',
                'provider_address' => 'Nha Trang',
                'provider_id' => 11,
                'pickup_info' => '20:00 - Van phong Nha Trang',
                'min_customers' => 0,
            ]],
            'dropoff_points' => [[
                'key' => 'dropoff-1',
                'name' => 'Van phong Sai Gon',
                'address' => 'Sai Gon',
                'provider_address' => 'Sai Gon',
                'provider_id' => 22,
                'dropoff_info' => '06:00 - Van phong Sai Gon',
                'dropoff_time' => '06:00',
                'min_customers' => 0,
            ]],
            'online_info' => ['trip_id' => 100],
        ];

        $this->mock(VexereTripService::class, function (MockInterface $mock) use ($tripDetails): void {
            $mock->shouldReceive('areaName')->twice()->andReturn('Area');
            $mock->shouldReceive('tripDetails')->once()->andReturn($tripDetails);
        });
        $this->mock(NhatDuongPublicBookingService::class, function (MockInterface $mock): void {
            $mock->shouldNotReceive('createOrder');
        });
        $this->mock(BookingEmailService::class, function (MockInterface $mock): void {
            $mock->shouldReceive('sendConfirmation')
                ->once()
                ->withArgs(fn (Booking $booking, string $sourceUrl, bool $adsMode) => $booking->ads_mode
                    && $booking->total_amount === 350000
                    && $adsMode);
        });

        $response = $this->post(route('booking.live.store'), [
            'route_id' => $route->id,
            'from_id' => 1,
            'to_id' => 2,
            'trip_code' => 'TRIP-ADS-1',
            'travel_date' => '2026-11-10',
            'passenger_count' => 1,
            'passenger_name' => 'Ads Customer',
            'passenger_email' => 't0972199672@gmail.com',
            'passenger_phone' => '0900000000',
            'pickup_point' => 'pickup-1',
            'dropoff_point' => 'dropoff-1',
            'selected_seats' => ['A01'],
            'selected_room_options' => [json_encode(['seatCode' => 'A01', 'id' => 10])],
            'payment_method' => 'bank_transfer',
            'terms' => '1',
            'lang' => 'vi',
        ]);

        $booking = Booking::sole();
        $response->assertRedirect(route('booking.success', ['booking' => $booking, 'lang' => 'vi']));
        $this->assertTrue($booking->ads_mode);
        $this->assertSame('ads_pending', $booking->payment_status);
        $this->assertNull($booking->public_booking_order_id);
        $this->assertDatabaseCount('booking_seats', 0);
    }
}
