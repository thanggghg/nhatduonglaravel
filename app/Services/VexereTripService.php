<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class VexereTripService
{
    public function search(string $from, string $to, Carbon $date, string $locale, ?Carbon $returnDate = null): array
    {
        return $this->searchMany([[
            'from' => $from,
            'to' => $to,
            'return_date' => $returnDate,
        ]], $date, $locale)[0] ?? [];
    }

    public function searchMany(array $queries, Carbon $date, string $locale): array
    {
        $areas = config('services.vexere.areas', []);
        $prepared = [];
        foreach ($queries as $key => $query) {
            $from = $query['from'];
            $to = $query['to'];
            $fromId = $areas[$from] ?? null;
            $toId = $areas[$to] ?? null;

            if (!$fromId || !$toId) {
                throw new RuntimeException('This route is not configured with the live booking provider.');
            }

            $prepared[$key] = compact('from', 'to', 'fromId', 'toId') + [
                'returnDate' => $query['return_date'] ?? null,
            ];
        }

        $token = $this->token($locale);
        $responses = Http::pool(function (Pool $pool) use ($prepared, $date, $locale, $token) {
            $requests = [];
            foreach ($prepared as $key => $query) {
                $requests[] = $pool->as((string) $key)
                    ->acceptJson()
                    ->withHeaders($this->headers($locale))
                    ->withToken($token)
                    ->timeout(15)
                    ->get(config('services.vexere.route_url'), $this->routeParameters($query['fromId'], $query['toId'], $date));
            }

            return $requests;
        });

        $trips = [];
        $hasLiveResponse = false;
        foreach ($prepared as $key => $query) {
            $response = $responses[(string) $key] ?? null;
            if (!$response || !$response->successful()) {
                continue;
            }

            $hasLiveResponse = true;
            $trips[$key] = $this->normalizeTrips(
                $response->json('data', []),
                $query['from'],
                $query['to'],
                $date,
                $locale,
                $query['returnDate']
            );
        }

        if (!$hasLiveResponse && $prepared) {
            throw new RuntimeException('Live departures are temporarily unavailable.');
        }

        return $trips;
    }

    private function normalizeTrips(array $results, string $from, string $to, Carbon $date, string $locale, ?Carbon $returnDate): array
    {
        $trips = [];
        foreach ($results as $result) {
            $route = $result['route'] ?? [];
            $company = $result['company'] ?? [];
            $image = data_get($company, 'images.0.files.1000x600');
            $image = $image ? (str_starts_with($image, '//') ? 'https://'.ltrim($image, '/') : $image) : null;

            foreach ($route['schedules'] ?? [] as $schedule) {
                $pickup = $route['from'] ?? [];
                $dropoff = $route['to'] ?? [];
                $fare = (int) (data_get($schedule, 'fare.discount') ?: data_get($schedule, 'fare.original'));
                $departure = Carbon::parse($schedule['pickup_date']);
                $arrival = Carbon::parse($schedule['arrival_time']);

                $trips[] = [
                    'code' => $schedule['trip_code'],
                    'departure' => $departure,
                    'arrival' => $arrival,
                    'fare' => $fare,
                    'available_seats' => (int) ($schedule['available_seats'] ?? 0),
                    'vehicle_type' => $schedule['vehicle_type'] ?? 'Sleeper cabin',
                    'duration' => (int) ($route['duration'] ?? 0),
                    'pickup' => $this->placeName($pickup, $locale, $from),
                    'dropoff' => $this->placeName($dropoff, $locale, $to),
                    'image' => $image,
                    'booking_url' => $this->bookingUrl($date, $from, $to, $returnDate, $locale),
                ];
            }
        }

        return $trips;
    }

    private function routeParameters(int $fromId, int $toId, Carbon $date): array
    {
        return [
            'filter[from]' => $fromId,
            'filter[to]' => $toId,
            'filter[date]' => $date->toDateString(),
            'filter[time][min]' => '00:00',
            'filter[time][max]' => '23:59',
            'filter[fare][min]' => 0,
            'filter[fare][max]' => 2000000,
            'filter[available_seat][min]' => 0,
            'filter[available_seat][max]' => 50,
            'filter[is_promotion]' => 0,
            'filter[companies][0]' => config('services.vexere.company_id'),
            'filter[companies][1]' => 0,
            'sort' => 'time:asc',
            'page' => 1,
            'pagesize' => 20,
        ];
    }

    private function token(string $locale): string
    {
        return Cache::remember('vexere.oauth_token.'.$locale, now()->addMinutes(50), function () use ($locale) {
            $response = Http::asForm()
                ->acceptJson()
                ->withHeaders($this->headers($locale))
                ->timeout(15)
                ->post(config('services.vexere.oauth_url'), [
                    'grant_type' => 'client_credentials',
                    'client_id' => config('services.vexere.client_id'),
                    'client_secret' => config('services.vexere.client_secret'),
                ]);

            $token = $response->json('access_token');
            if (!$response->successful() || !$token) {
                throw new RuntimeException('Live booking authentication is unavailable.');
            }

            return $token;
        });
    }

    private function bookingUrl(Carbon $date, string $from, string $to, ?Carbon $returnDate, string $locale): string
    {
        return route('booking.search', [
            'from_location' => $from,
            'to_location' => $to,
            'departDate' => $date->format('d-m-Y'),
            'returnDate' => $returnDate?->format('d-m-Y'),
            'is_round_trip' => $returnDate ? 1 : 0,
            'lang' => $locale,
        ]);
    }

    private function headers(string $locale): array
    {
        $languages = [
            'vi' => 'vi-VN,vi;q=0.9',
            'en' => 'en-US,en;q=0.9',
            'ru' => 'ru-RU,ru;q=0.9,en;q=0.8',
        ];

        return [
            'Accept-Language' => $languages[$locale] ?? $languages['en'],
            'Origin' => 'https://nhatduongcol.com',
            'Referer' => 'https://nhatduongcol.com/',
        ];
    }

    private function placeName(array $place, string $locale, string $fallback): string
    {
        if ($locale !== 'vi' && filled($place['english_name'] ?? null)) {
            return $place['english_name'];
        }

        return $place['name'] ?? $fallback;
    }
}
