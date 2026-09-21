<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class VexereTripService
{
    public function search(string|int $from, string|int $to, Carbon $date, string $locale, ?Carbon $returnDate = null): array
    {
        return $this->searchMany([[
            'from' => $from,
            'to' => $to,
            'return_date' => $returnDate,
        ]], $date, $locale)[0] ?? [];
    }

    public function findTrip(string|int $from, string|int $to, Carbon $date, string $locale, string $tripCode): ?array
    {
        return collect($this->search($from, $to, $date, $locale))->firstWhere('code', $tripCode);
    }

    public function seatMap(string|int $from, string|int $to, string $tripCode, string $locale): array
    {
        return $this->tripDetails($from, $to, $tripCode, $locale)['coaches'];
    }

    public function tripDetails(string|int $from, string|int $to, string $tripCode, string $locale): array
    {
        $fromId = $this->areaId($from);
        $toId = $this->areaId($to);
        if (!$fromId || !$toId) {
            throw new RuntimeException('This route is not configured with the live booking provider.');
        }

        // Short cache avoids a redundant VeXeRe HTTP call when checkout-live page
        // already fetched this data. Carbon objects are converted to strings for safe serialization.
        $cacheKey = 'vexere.trip_detail:'.md5($tripCode.'|'.$fromId.'|'.$toId.'|'.$locale);
        $cached = Cache::get($cacheKey);
        if (is_array($cached)) {
            $cached['trip']['departure'] = isset($cached['trip']['departure_string'])
                ? Carbon::createFromFormat('Y-m-d H:i:s', $cached['trip']['departure_string'], 'Asia/Ho_Chi_Minh')
                : null;
            $cached['trip']['arrival'] = isset($cached['trip']['arrival_string'])
                ? Carbon::createFromFormat('Y-m-d H:i:s', $cached['trip']['arrival_string'], 'Asia/Ho_Chi_Minh')
                : null;
            return $cached;
        }

        $response = Http::acceptJson()
            ->withHeaders($this->headers($locale))
            ->withToken($this->token($locale))
            ->connectTimeout(5)
            ->timeout(15)
            ->retry(1, 200, fn (\Throwable $exception) => $exception instanceof ConnectionException, false)
            ->get(rtrim(config('services.vexere.trip_url'), '/').'/'.rawurlencode($tripCode), [
                'from' => $fromId,
                'to' => $toId,
            ]);

        if (!$response->successful()) {
            throw new RuntimeException('Live seat availability is temporarily unavailable.');
        }

        $data = $response->json('data', []);
        $onlineInfo = data_get($data, 'online_info', []);
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

        $departureRaw = $onlineInfo['departure_time'] ?? null;
        $departure = null;
        if (is_string($departureRaw) && $departureRaw !== '') {
            try {
                $departure = Carbon::createFromFormat('H:i d-m-Y', $departureRaw, 'Asia/Ho_Chi_Minh');
            } catch (\Throwable) {
                $departure = null;
            }
        }
        $duration = (int) ($response->json('data.route.duration', 0));
        $arrival = $departure ? $departure->copy()->addMinutes($duration) : null;
        $fare = (int) ($onlineInfo['fare'] ?? 0);
        $availableSeats = (int) ($onlineInfo['total_available_seats'] ?? 0);
        $vehicleType = $onlineInfo['name'] ?? ($onlineInfo['vehicle']['seat_type'] ?? 'Sleeper cabin');
        $images = $this->normalizeImages(data_get($data, 'operator.images', []));
        $image = $images[0] ?? null;
        $fromLabel = $this->placeName($response->json('data.route.from', []) ?? [], $locale, $this->areaName($fromId) ?? (string) $from);
        $toLabel = $this->placeName($response->json('data.route.to', []) ?? [], $locale, $this->areaName($toId) ?? (string) $to);
        $originalFare = (int) ($this->firstNumeric([
            $onlineInfo['original_fare'] ?? null,
            $onlineInfo['fare_original'] ?? null,
            data_get($onlineInfo, 'fare_detail.original'),
            data_get($data, 'default_info.fare.original'),
        ]) ?? $fare);
        $originalFare = max($fare, $originalFare);

        $result = [
            'coaches' => $coaches,
            'trip' => [
                'code' => $tripCode,
                'departure' => $departure,
                'arrival' => $arrival,
                'fare' => $fare,
                'original_fare' => $originalFare,
                'discount_percent' => $originalFare > $fare ? (int) round((1 - ($fare / $originalFare)) * 100) : 0,
                'available_seats' => $availableSeats,
                'vehicle_type' => $vehicleType,
                'duration' => $duration,
                'pickup' => $fromLabel,
                'dropoff' => $toLabel,
                'image' => $image,
                'booking_from_id' => (int) (explode('|', (string) ($onlineInfo['from_area'] ?? ''))[0] ?? 0) ?: null,
                'booking_to_id' => (int) (explode('|', (string) ($onlineInfo['to_area'] ?? ''))[0] ?? 0) ?: null,
                'departure_string' => $departure?->format('Y-m-d H:i:s'),
                'arrival_string' => $arrival?->format('Y-m-d H:i:s'),
            ],
            'online_info' => [
                'trip_id' => $onlineInfo['trip_id'] ?? null,
                'search_from' => $onlineInfo['search_from'] ?? null,
                'search_to' => $onlineInfo['search_to'] ?? null,
            ],
            'pickup_points' => $this->normalizePoints($onlineInfo['pickup_points'] ?? [], $locale, true),
            'dropoff_points' => $this->normalizePoints($onlineInfo['drop_off_points_at_arrive'] ?? [], $locale),
            'rating' => [
                'score' => $this->firstNumeric([
                    data_get($data, 'operator.ratings.overall'),
                    data_get($data, 'operator.rating'),
                    data_get($data, 'operator.average_rating'),
                    data_get($data, 'operator.rate'),
                ]),
                'count' => (int) ($this->firstNumeric([
                    data_get($data, 'operator.ratings.total_rating'),
                    data_get($data, 'operator.review_count'),
                    data_get($data, 'operator.total_review'),
                    data_get($data, 'operator.total_reviews'),
                    data_get($data, 'operator.rating_count'),
                ]) ?? 0),
                'comments' => $this->normalizeReviews(
                    data_get($data, 'operator.comments')
                    ?? data_get($data, 'operator.reviews')
                    ?? data_get($data, 'reviews')
                    ?? []
                ),
            ],
            'policies' => $this->normalizePolicies($data, $locale),
            'images' => $images,
            'amenities' => $this->normalizeAmenities(array_merge(
                (array) data_get($data, 'route.utilities', []),
                (array) data_get($data, 'online_info.utilities', []),
                (array) data_get($data, 'default_info.utilities', [])
            ), $locale),
        ];

        Cache::put($cacheKey, $result, now()->addSeconds(30));

        return $result;
    }

    public function searchMany(array $queries, Carbon $date, string $locale): array
    {
        $prepared = [];
        foreach ($queries as $key => $query) {
            $fromId = $this->areaId($query['from']);
            $toId = $this->areaId($query['to']);

            if (!$fromId || !$toId) {
                throw new RuntimeException('This route is not configured with the live booking provider.');
            }

            $from = $this->areaName($fromId) ?? (string) $query['from'];
            $to = $this->areaName($toId) ?? (string) $query['to'];
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
                    ->connectTimeout(5)
                    ->timeout(15)
                    ->retry(1, 200, fn (\Throwable $exception) => $exception instanceof ConnectionException, false)
                    ->get(config('services.vexere.route_url'), $this->routeParameters($query['fromId'], $query['toId'], $date));
            }

            return $requests;
        });

        $trips = [];
        $hasLiveResponse = false;
        foreach ($prepared as $key => $query) {
            $response = $responses[(string) $key] ?? null;
            if (!$response instanceof Response || !$response->successful()) {
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

    public function areaId(string|int $area): ?int
    {
        if (is_numeric($area)) {
            $id = (int) $area;

            return in_array($id, array_map('intval', config('services.vexere.areas', [])), true) ? $id : null;
        }

        $id = config('services.vexere.areas', [])[$area] ?? null;

        return is_numeric($id) ? (int) $id : null;
    }

    public function areaName(int $areaId): ?string
    {
        foreach (config('services.vexere.areas', []) as $name => $id) {
            if ((int) $id === $areaId) {
                return $name;
            }
        }

        return null;
    }

    private function normalizeTrips(array $results, string $from, string $to, Carbon $date, string $locale, ?Carbon $returnDate): array
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
                $discountFare = (int) data_get($schedule, 'fare.discount', 0);
                $originalFare = (int) data_get($schedule, 'fare.original', 0);
                $fare = $discountFare > 0 ? $discountFare : max(0, $originalFare);
                $originalFare = max($fare, $originalFare);
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
                    'original_fare' => $originalFare,
                    'discount_percent' => $originalFare > $fare ? (int) round((1 - ($fare / $originalFare)) * 100) : 0,
                    'utility_ids' => array_values(array_filter((array) ($route['utilities'] ?? []), 'is_numeric')),
                    'available_seats' => (int) ($schedule['available_seats'] ?? 0),
                    'vehicle_type' => $schedule['vehicle_type'] ?? 'Sleeper cabin',
                    'duration' => (int) ($route['duration'] ?? 0),
                    'pickup' => $this->placeName($pickup, $locale, $from),
                    'dropoff' => $this->placeName($dropoff, $locale, $to),
                    'booking_from_id' => is_numeric($bookingFromId) ? (int) $bookingFromId : null,
                    'booking_to_id' => is_numeric($bookingToId) ? (int) $bookingToId : null,
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
            'pagesize' => 100,
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
                $bookingAreaId = $point['point_id'] ?? $point['area_id'] ?? data_get($point, 'areaDetail.id');

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
                    'pickup_info' => $isPickup && filled($providerName) && filled($providerAddress) && filled($providerId)
                        ? $providerName.' - '.$providerAddress.'||0|'.$providerId.'|'
                        : null,
                    'dropoff_info' => !$isPickup && filled($providerName) && filled($providerAddress)
                        ? $providerName.' - '.$providerAddress
                        : (!$isPickup && filled($providerAddress) ? $providerAddress : null),
                    'dropoff_time' => !$isPickup ? $this->isoDateTime($point['real_time'] ?? null) : null,
                ];
            })
            ->values()
            ->all();
    }

    public static function utilityLabels(): array
    {
        return [
            10 => ['vi' => 'Nhân viên sử dụng tiếng Anh', 'en' => 'English-speaking staff', 'ru' => 'Англоговорящий персонал'],
            11 => ['vi' => 'Bánh ngọt', 'en' => 'Snacks', 'ru' => 'Закуски'],
            14 => ['vi' => 'Toilet', 'en' => 'Toilet', 'ru' => 'Туалет'],
            17 => ['vi' => 'Đèn đọc sách', 'en' => 'Reading light', 'ru' => 'Лампа для чтения'],
            21 => ['vi' => 'Dây đai an toàn', 'en' => 'Seat belt', 'ru' => 'Ремень безопасности'],
            23 => ['vi' => 'Nước uống', 'en' => 'Drinking water', 'ru' => 'Питьевая вода'],
            24 => ['vi' => 'Gối nằm', 'en' => 'Pillow', 'ru' => 'Подушка'],
            25 => ['vi' => 'Búa phá kính', 'en' => 'Emergency hammer', 'ru' => 'Аварийный молоток'],
            36 => ['vi' => 'Búa phá kính', 'en' => 'Emergency hammer', 'ru' => 'Аварийный молоток'],
            27 => ['vi' => 'Tivi LED', 'en' => 'LED TV', 'ru' => 'LED-телевизор'],
            29 => ['vi' => 'Sạc điện thoại', 'en' => 'Phone charging', 'ru' => 'Зарядка телефона'],
            31 => ['vi' => 'Rèm cửa', 'en' => 'Window curtains', 'ru' => 'Шторы'],
            52 => ['vi' => 'Dàn âm thanh', 'en' => 'Sound system', 'ru' => 'Аудиосистема'],
            54 => ['vi' => 'Wi-Fi', 'en' => 'Wi-Fi', 'ru' => 'Wi-Fi'],
            55 => ['vi' => 'Điều hòa', 'en' => 'Air conditioning', 'ru' => 'Кондиционер'],
            57 => ['vi' => 'Khăn lạnh', 'en' => 'Cold towel', 'ru' => 'Холодное полотенце'],
        ];
    }

    private function normalizeImages(mixed $images): array
    {
        return collect(is_array($images) ? $images : [])
            ->map(function ($image) {
                if (is_string($image)) {
                    $url = $image;
                } else {
                    $files = is_array($image) ? ($image['files'] ?? []) : [];
                    $url = collect(['1000x600', '600x400', '300x200', 'original'])
                        ->map(fn (string $size) => $files[$size] ?? null)
                        ->first(fn ($value) => is_string($value) && $value !== '')
                        ?? (is_array($image) ? ($image['url'] ?? null) : null);
                }

                if (!is_string($url) || $url === '') {
                    return null;
                }

                return str_starts_with($url, '//') ? 'https://'.ltrim($url, '/') : $url;
            })
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    private function normalizeAmenities(array $utilities, string $locale): array
    {
        $labels = self::utilityLabels();

        return collect($utilities)
            ->map(function ($utility) use ($labels, $locale) {
                $id = is_numeric($utility) ? (int) $utility : (int) ($utility['id'] ?? $utility['utility_id'] ?? 0);
                $name = is_array($utility)
                    ? ($locale !== 'vi' ? ($utility['english_name'] ?? null) : null) ?? ($utility['name'] ?? null)
                    : null;
                $name = $name ?: ($labels[$id][$locale] ?? $labels[$id]['en'] ?? null);

                if (!$name) {
                    return null;
                }

                $price = is_array($utility) ? ($utility['price'] ?? $utility['fee'] ?? null) : null;
                $freeFlag = is_array($utility) ? ($utility['is_free'] ?? $utility['free'] ?? null) : true;
                $isFree = $freeFlag !== null
                    ? filter_var($freeFlag, FILTER_VALIDATE_BOOL)
                    : ($price === null || (is_numeric($price) && (float) $price <= 0));

                return ['id' => $id ?: null, 'name' => trim((string) $name), 'is_free' => $isFree];
            })
            ->filter()
            ->unique(fn (array $utility) => mb_strtolower($utility['name']))
            ->values()
            ->all();
    }

    public function amenities(array $utilities, string $locale): array
    {
        return $this->normalizeAmenities($utilities, $locale);
    }

    private function normalizeReviews(mixed $reviews): array
    {
        if (is_array($reviews)) {
            $reviews = $reviews['data'] ?? $reviews['items'] ?? $reviews['reviews'] ?? $reviews;
        }

        return collect(is_array($reviews) ? $reviews : [])
            ->map(function ($review) {
                if (is_string($review)) {
                    return ['author' => null, 'content' => trim(strip_tags($review)), 'rating' => null];
                }
                if (!is_array($review)) {
                    return null;
                }

                $content = $review['content'] ?? $review['comment'] ?? $review['review'] ?? $review['text'] ?? null;
                if (!is_string($content) || trim(strip_tags($content)) === '') {
                    return null;
                }

                return [
                    'author' => $review['customer_name'] ?? $review['author'] ?? $review['name'] ?? null,
                    'content' => trim(html_entity_decode(strip_tags($content))),
                    'rating' => $this->firstNumeric([$review['rating'] ?? null, $review['score'] ?? null]),
                ];
            })
            ->filter()
            ->take(5)
            ->values()
            ->all();
    }

    private function normalizePolicies(array $data, string $locale): array
    {
        $paths = [
            'cancellation' => ['online_info.cancel_policy', 'online_info.cancellation_policy', 'online_info.refund_policy', 'operator.cancel_policy', 'online_info.config_ticket_refundable'],
            'payment' => ['online_info.payment_policy', 'online_info.payment_note', 'operator.payment_policy', 'online_info.payment_method'],
            'e_ticket' => ['online_info.ticket_policy', 'online_info.e_ticket_policy', 'online_info.booking_policy', 'online_info.booking_note', 'online_info.using_eticket'],
            'deposit' => ['online_info.deposit_policy', 'online_info.deposit_note', 'online_info.required_deposit', 'online_info.deposit', 'online_info.deposit_selling'],
        ];

        return collect($paths)->map(function (array $candidates, string $policy) use ($data, $locale) {
            foreach ($candidates as $path) {
                $value = data_get($data, $path);
                $text = match ($path) {
                    'online_info.config_ticket_refundable' => $this->policyFlagText('cancellation', $value, $locale),
                    'online_info.payment_method' => filled($value) ? $this->policyFlagText('payment', true, $locale) : null,
                    'online_info.using_eticket' => $this->policyFlagText('e_ticket', $value, $locale),
                    'online_info.deposit_selling' => $this->policyFlagText('deposit', $value, $locale),
                    default => $this->policyText($value, $locale),
                };
                if ($text !== null) {
                    return $text;
                }
            }

            return null;
        })->all();
    }

    private function policyFlagText(string $policy, mixed $value, string $locale): ?string
    {
        if (!is_bool($value) && !is_numeric($value)) {
            return null;
        }
        $enabled = (bool) $value;
        $messages = [
            'vi' => [
                'cancellation' => ['Chuyến này hỗ trợ hoàn/hủy vé.', 'Chuyến này không hỗ trợ hoàn/hủy vé.'],
                'payment' => ['VeXeRe đã cấu hình phương thức thanh toán cho chuyến này.', 'Chuyến này chưa có phương thức thanh toán trên VeXeRe.'],
                'e_ticket' => ['Chuyến này có hỗ trợ vé điện tử.', 'Chuyến này không sử dụng vé điện tử.'],
                'deposit' => ['Chuyến này yêu cầu đặt cọc.', 'Chuyến này không yêu cầu đặt cọc.'],
            ],
            'en' => [
                'cancellation' => ['This departure supports refunds or cancellations.', 'This departure does not support refunds or cancellations.'],
                'payment' => ['VeXeRe has configured payment methods for this departure.', 'No payment method is configured on VeXeRe for this departure.'],
                'e_ticket' => ['E-tickets are supported for this departure.', 'E-tickets are not used for this departure.'],
                'deposit' => ['A deposit is required for this departure.', 'No deposit is required for this departure.'],
            ],
            'ru' => [
                'cancellation' => ['Для этого рейса доступен возврат или отмена.', 'Для этого рейса возврат и отмена недоступны.'],
                'payment' => ['VeXeRe настроил способы оплаты для этого рейса.', 'Для этого рейса на VeXeRe не настроен способ оплаты.'],
                'e_ticket' => ['Для этого рейса доступен электронный билет.', 'Для этого рейса электронный билет не используется.'],
                'deposit' => ['Для этого рейса требуется депозит.', 'Для этого рейса депозит не требуется.'],
            ],
        ];

        return ($messages[$locale] ?? $messages['en'])[$policy][$enabled ? 0 : 1];
    }

    private function policyText(mixed $value, string $locale): ?string
    {
        if (is_bool($value)) {
            $boolean = [
                'vi' => ['Có', 'Không'],
                'en' => ['Yes', 'No'],
                'ru' => ['Да', 'Нет'],
            ][$locale] ?? ['Yes', 'No'];

            return $value ? $boolean[0] : $boolean[1];
        }
        if (is_numeric($value)) {
            return (string) $value;
        }
        if (is_string($value)) {
            $text = trim(html_entity_decode(strip_tags($value)));
            return $text !== '' ? $text : null;
        }
        if (!is_array($value)) {
            return null;
        }

        $parts = collect($value)->flatten()->filter(fn ($part) => is_scalar($part))
            ->map(fn ($part) => trim(html_entity_decode(strip_tags((string) $part))))
            ->filter()->unique()->values();

        return $parts->isNotEmpty() ? $parts->implode(' · ') : null;
    }

    private function firstNumeric(array $values): int|float|null
    {
        foreach ($values as $value) {
            if (is_numeric($value)) {
                return $value + 0;
            }
        }

        return null;
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
