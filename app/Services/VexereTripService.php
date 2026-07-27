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

    public function findTrip(string $from, string $to, Carbon $date, string $locale, string $tripCode): ?array
    {
        return collect($this->search($from, $to, $date, $locale))->firstWhere('code', $tripCode);
    }

    public function seatMap(string $from, string $to, string $tripCode, string $locale): array
    {
        $areas = config('services.vexere.areas', []);
        $fromId = $areas[$from] ?? null;
        $toId = $areas[$to] ?? null;
        if (!$fromId || !$toId) {
            throw new RuntimeException('This route is not configured with the live booking provider.');
        }

        $response = Http::acceptJson()
            ->withHeaders($this->headers($locale))
            ->withToken($this->token($locale))
            ->timeout(15)
            ->get(rtrim(config('services.vexere.trip_url'), '/').'/'.rawurlencode($tripCode), [
                'from' => $fromId,
                'to' => $toId,
            ]);

        if (!$response->successful()) {
            throw new RuntimeException('Live seat availability is temporarily unavailable.');
        }

        $templates = $response->json('data.online_info.coach_seat_template', []);
        if (!$templates) {
            $templates = $response->json('data.default_info.coach_seat_template', []);
        }

        $coaches = [];
        foreach ($templates as $coach) {
            $seats = [];
            foreach ($coach['seats'] ?? [] as $seat) {
                $seatCode = $seat['seat_code'] ?? null;
                $coachNumber = $seat['coach_num'] ?? $coach['coach_num'] ?? 1;
                $row = $seat['row_num'] ?? 1;
                $column = $seat['col_num'] ?? 1;
                if (!$seatCode) {
                    continue;
                }

                $seats[] = [
                    'key' => implode('|', [$seatCode, $coachNumber, $row, $column]),
                    'code' => $seatCode,
                    'coach' => $coachNumber,
                    'row' => (int) $row,
                    'column' => (int) $column,
                    'row_span' => max(1, (int) ($seat['row_span'] ?? 1)),
                    'column_span' => max(1, (int) ($seat['col_span'] ?? 1)),
                    'type' => $seat['seat_type'] ?? null,
                    'fare' => (int) ($seat['fare'] ?? 0),
                    'available' => (bool) ($seat['is_available'] ?? false),
                    'locked' => (bool) ($seat['is_locked_seat'] ?? false),
                ];
            }

            if ($seats) {
                $coaches[] = [
                    'number' => $coach['coach_num'] ?? $coach['coach_number'] ?? count($coaches) + 1,
                    'name' => $coach['coach_name'] ?? null,
                    'rows' => (int) ($coach['num_rows'] ?? 0),
                    'columns' => (int) ($coach['num_cols'] ?? 0),
                    'seats' => $seats,
                ];
            }
        }

        if (!$coaches) {
            throw new RuntimeException('Live seat availability is temporarily unavailable.');
        }

        return $coaches;
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
                $query['fromId'],
                $query['toId'],
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

    private function normalizeTrips(array $results, string $from, string $to, int $fromId, int $toId, Carbon $date, string $locale, ?Carbon $returnDate): array
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
                    'booking_url' => $this->bookingUrl($fromId, $toId, $date, $from, $to, $returnDate),
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

    private function bookingUrl(int $fromId, int $toId, Carbon $date, string $from, string $to, ?Carbon $returnDate): string
    {
        return 'https://nhaxenhatduong.com/dat-ve-truc-tuyen?'.http_build_query([
            'from' => $fromId,
            'to' => $toId,
            'departDate' => $date->format('d-m-Y'),
            'fromLabel' => $from,
            'toLabel' => $to,
            'returnDate' => $returnDate?->format('d-m-Y'),
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
