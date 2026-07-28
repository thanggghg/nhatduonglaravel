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
        return $this->tripDetails($from, $to, $tripCode, $locale)['coaches'];
    }

    public function tripDetails(string $from, string $to, string $tripCode, string $locale): array
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

        $onlineInfo = $response->json('data.online_info', []);
        if (!is_array($onlineInfo)) {
            $onlineInfo = [];
        }
        $templates = $onlineInfo['coach_seat_template'] ?? [];
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

                $roomOptions = collect($seat['seat_groups'] ?? [[
                    'seat_group_id' => $seat['seat_group_id'] ?? null,
                    'seat_group_code' => $seat['seat_group_code'] ?? null,
                    'seat_group' => $seat['seat_group'] ?? null,
                    'seat_group_english' => $seat['seat_group_english'] ?? null,
                    'fare' => $seat['fare'] ?? 0,
                    'seat_color' => $seat['seat_color'] ?? null,
                ]])->map(function (array $group) use ($locale) {
                    return [
                        'id' => is_numeric($group['seat_group_id'] ?? null) ? (int) $group['seat_group_id'] : null,
                        'code' => $group['seat_group_code'] ?? null,
                        'name' => $locale !== 'vi' && filled($group['seat_group_english'] ?? null)
                            ? $group['seat_group_english']
                            : ($group['seat_group'] ?? null),
                        'fare' => (int) ($group['fare'] ?? 0),
                        'color' => $group['seat_color'] ?? null,
                    ];
                })->values();
                $lowestRoomFare = $roomOptions->min('fare');
                $roomOptions = $roomOptions->map(fn (array $group) => $group + [
                    'customer_amount' => $group['fare'] === $lowestRoomFare ? 1 : 2,
                ])->all();
                $selectedRoom = collect($roomOptions)->firstWhere('code', $seat['seat_group_code'] ?? null) ?? $roomOptions[0] ?? [];
                $roomName = $selectedRoom['name'] ?? null;
                $roomCode = $seat['seat_group_code'] ?? '';

                $seats[] = [
                    'key' => implode('|', [$seatCode, $coachNumber, $row, $column]),
                    'code' => $seatCode,
                    'coach' => $coachNumber,
                    'row' => (int) $row,
                    'column' => (int) $column,
                    'row_span' => max(1, (int) ($seat['row_span'] ?? 1)),
                    'column_span' => max(1, (int) ($seat['col_span'] ?? 1)),
                    'type' => $seat['seat_type'] ?? null,
                    'seat_type' => $seat['seat_type'] ?? null,
                    'fare' => (int) ($selectedRoom['fare'] ?? $seat['fare'] ?? 0),
                    'room_name' => $roomName,
                    'room_code' => $roomCode,
                    'room_color' => $selectedRoom['color'] ?? $seat['seat_color'] ?? null,
                    'room_options' => $roomOptions,
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

        return [
            'coaches' => $coaches,
            'online_info' => [
                'trip_id' => $onlineInfo['trip_id'] ?? null,
                'search_from' => $onlineInfo['search_from'] ?? null,
                'search_to' => $onlineInfo['search_to'] ?? null,
            ],
            'pickup_points' => $this->normalizePoints($onlineInfo['pickup_points'] ?? [], $locale, true),
            'dropoff_points' => $this->normalizePoints($onlineInfo['drop_off_points_at_arrive'] ?? [], $locale),
        ];
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
            $idIndexParts = explode('_', (string) ($result['idIndex'] ?? ''));
            $idIndex = array_values(array_filter($idIndexParts, 'is_numeric'));
            $bookingFromId = count($idIndex) >= 2 ? $idIndex[count($idIndex) - 2] : data_get($route, 'pickup_points.0.area_id');
            $bookingToId = count($idIndex) >= 1 ? $idIndex[count($idIndex) - 1] : data_get($route, 'dropoff_points.0.area_id');
            $tripDatePart = collect($idIndexParts)->first(fn (string $part) => preg_match('/^\d{4}-\d{2}-\d{2}$/', $part));
            $tripTimePart = collect($idIndexParts)->first(fn (string $part) => preg_match('/^\d{2}:\d{2}$/', $part));
            $image = data_get($company, 'images.0.files.1000x600');
            $image = $image ? (str_starts_with($image, '//') ? 'https://'.ltrim($image, '/') : $image) : null;

            foreach ($route['schedules'] ?? [] as $schedule) {
                $pickup = $route['from'] ?? [];
                $dropoff = $route['to'] ?? [];
                $fare = (int) (data_get($schedule, 'fare.discount') ?: data_get($schedule, 'fare.original'));
                $departure = Carbon::parse($schedule['pickup_date']);
                $arrival = Carbon::parse($schedule['arrival_time']);
                $tripDeparture = $tripDatePart && $tripTimePart
                    ? Carbon::createFromFormat('Y-m-d H:i', $tripDatePart.' '.$tripTimePart, 'Asia/Ho_Chi_Minh')
                    : $departure->copy();

                $trips[] = [
                    'code' => $schedule['trip_code'],
                    'departure' => $departure,
                    'provider_trip_departure' => $tripDeparture,
                    'arrival' => $arrival,
                    'fare' => $fare,
                    'available_seats' => (int) ($schedule['available_seats'] ?? 0),
                    'vehicle_type' => $schedule['vehicle_type'] ?? 'Sleeper cabin',
                    'duration' => (int) ($route['duration'] ?? 0),
                    'pickup' => $this->placeName($pickup, $locale, $from),
                    'dropoff' => $this->placeName($dropoff, $locale, $to),
                    'booking_from_id' => is_numeric($bookingFromId) ? (int) $bookingFromId : null,
                    'booking_to_id' => is_numeric($bookingToId) ? (int) $bookingToId : null,
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

    private function normalizePoints(array $points, string $locale, bool $isPickup = false): array
    {
        return collect($points)
            ->filter(fn (array $point) => (int) ($point['hidden'] ?? 0) === 0 && ($point['is_vxr_display'] ?? true) !== false)
            ->sortBy(fn (array $point) => (int) ($point['index'] ?? 0))
            ->map(function (array $point) use ($locale, $isPickup) {
                $name = $locale !== 'vi' && filled($point['english_name'] ?? null) ? $point['english_name'] : ($point['name'] ?? '');
                $address = $locale !== 'vi' && filled($point['english_address'] ?? null) ? $point['english_address'] : ($point['address'] ?? '');
                $providerName = $point['name'] ?? null;
                $providerAddress = $point['address'] ?? null;
                $providerId = $point['id'] ?? null;
                $pointId = $point['point_id'] ?? null;
                $bookingAreaId = $point['area_id'] ?? data_get($point, 'areaDetail.id');

                return [
                    'key' => implode(':', [$point['point_id'] ?? '', $point['id'] ?? '', $point['index'] ?? '']),
                    'name' => $name,
                    'address' => $address,
                    'time' => $point['real_time'] ?? (string) ($point['time'] ?? ''),
                    'min_customers' => (int) ($point['min_customer'] ?? 0),
                    'provider_name' => $providerName,
                    'provider_address' => $providerAddress,
                    'provider_id' => $providerId,
                    'point_id' => $pointId,
                    'booking_area_id' => is_numeric($bookingAreaId) ? (int) $bookingAreaId : null,
                    'pickup_info' => $isPickup && filled($providerAddress) && filled($providerId)
                        ? $providerAddress.'||0|'.$providerId.'|'
                        : null,
                    'dropoff_info' => !$isPickup && filled($providerAddress) ? $providerAddress : null,
                    'dropoff_time' => !$isPickup ? $this->isoDateTime($point['real_time'] ?? null) : null,
                ];
            })
            ->values()
            ->all();
    }

    private function isoDateTime(mixed $value): ?string
    {
        if (!is_string($value) || $value === '') {
            return null;
        }

        try {
            return Carbon::createFromFormat('H:i d-m-Y', $value, 'Asia/Ho_Chi_Minh')->toAtomString();
        } catch (\Throwable) {
            return null;
        }
    }
}
