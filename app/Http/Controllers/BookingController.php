<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\Route as BusRoute;
use App\Models\Schedule;
use App\Services\NhatDuongPublicBookingService;
use App\Services\VexereTripService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function __construct(
        private VexereTripService $vexere,
        private NhatDuongPublicBookingService $publicBooking,
    )
    {
    }

    public function search(Request $request)
    {
        [$route, $date, $returnDate, $passengerCount, $locale] = $this->searchContext($request);
        $isRoundTrip = $returnDate !== null;

        try {
            $trips = $this->vexere->search($route->from_location, $route->to_location, $date, $locale, $returnDate);
            $returnTrips = $isRoundTrip
                ? $this->vexere->search($route->to_location, $route->from_location, $returnDate, $locale)
                : [];
            $apiError = null;
        } catch (\Throwable $exception) {
            report($exception);
            $trips = [];
            $returnTrips = [];
            $apiError = true;
        }

        return view('booking.search', compact(
            'route',
            'date',
            'returnDate',
            'passengerCount',
            'locale',
            'isRoundTrip',
            'trips',
            'returnTrips',
            'apiError'
        ));
    }

    public function checkout(Request $request)
    {
        $context = $this->checkoutContext($request);

        return view('booking.checkout', $context);
    }

    public function checkoutLive(Request $request)
    {
        $context = $this->liveCheckoutContext($request);
        extract($context);
        $route->load(['pickupPoints', 'dropoffPoints']);
        $this->syncCancelledProviderBookings($trip['code'], $date);
        $reservedSeats = $this->reservedSeats($trip['code'], $date);
        try {
            $tripDetails = $this->vexere->tripDetails($route->from_location, $route->to_location, $trip['code'], $locale);
            $seatMap = $tripDetails['coaches'];
            $seatError = false;
        } catch (\Throwable $exception) {
            report($exception);
            $seatMap = [];
            $tripDetails = ['pickup_points' => [], 'dropoff_points' => []];
            $seatError = true;
        }
        $pickupOptions = collect($tripDetails['pickup_points'])->filter(fn (array $point) => !$point['min_customers'] || $point['min_customers'] <= $passengerCount)->map(fn (array $point) => (object) $point)->values();
        $dropoffOptions = collect($tripDetails['dropoff_points'])->filter(fn (array $point) => !$point['min_customers'] || $point['min_customers'] <= $passengerCount)->map(fn (array $point) => (object) $point)->values();

        return view('booking.checkout-live', compact('route', 'date', 'passengerCount', 'locale', 'trip', 'reservedSeats', 'seatMap', 'seatError', 'pickupOptions', 'dropoffOptions'));
    }

    public function liveSeats(Request $request): JsonResponse
    {
        $context = $this->liveCheckoutContext($request);
        $tripDetails = $this->vexere->tripDetails($context['route']->from_location, $context['route']->to_location, $context['trip']['code'], $context['locale']);
        $seatMap = $tripDetails['coaches'];
        $this->syncCancelledProviderBookings($context['trip']['code'], $context['date']);
        $reservedSeats = $this->reservedSeats($context['trip']['code'], $context['date']);
        $availableSeats = count(array_diff($this->availableSeatKeys($seatMap), $reservedSeats));

        return response()->json([
            'reserved_seats' => $reservedSeats,
            'available_seats' => $availableSeats,
            'coaches' => $seatMap,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'route_id' => 'required|integer|exists:routes,id',
            'schedule_id' => 'required|integer|exists:schedules,id',
            'travel_date' => 'required|date_format:Y-m-d',
            'is_round_trip' => 'required|boolean',
            'return_schedule_id' => 'nullable|integer|exists:schedules,id',
            'return_travel_date' => 'nullable|date_format:Y-m-d',
            'passenger_count' => 'required|integer|min:1|max:6',
            'passenger_name' => 'required|string|max:120',
            'passenger_email' => 'nullable|email:rfc,dns|max:120|required_without:passenger_phone',
            'passenger_phone' => 'nullable|string|max:50|required_without:passenger_email',
            'pickup_point' => 'required|string|max:255',
            'dropoff_point' => 'required|string|max:255',
            'seat_preference' => 'nullable|in:any,lower,upper',
            'notes' => 'nullable|string|max:1500',
            'terms' => 'accepted',
            'lang' => 'nullable|in:vi,en,ru',
        ]);

        $route = BusRoute::where('status', true)->findOrFail($validated['route_id']);
        $date = Carbon::createFromFormat('Y-m-d', $validated['travel_date'])->startOfDay();
        if ($date->isPast()) {
            throw ValidationException::withMessages(['travel_date' => 'Please choose a future travel date.']);
        }

        $isRoundTrip = (bool) $validated['is_round_trip'];
        $returnDate = null;
        if ($isRoundTrip) {
            if (!$validated['return_schedule_id'] || !$validated['return_travel_date']) {
                throw ValidationException::withMessages(['return_schedule_id' => 'Please select a return departure.']);
            }

            $returnDate = Carbon::createFromFormat('Y-m-d', $validated['return_travel_date'])->startOfDay();
            if ($returnDate->lt($date)) {
                throw ValidationException::withMessages(['return_travel_date' => 'Return travel cannot be before departure.']);
            }
        }

        $booking = DB::transaction(function () use ($validated, $route, $date, $returnDate, $isRoundTrip) {
            $schedule = Schedule::where('route_id', $route->id)->where('status', true)->lockForUpdate()->findOrFail($validated['schedule_id']);
            $this->ensureCapacity($schedule, $date, $validated['passenger_count']);

            $returnSchedule = null;
            if ($isRoundTrip) {
                $returnRoute = BusRoute::where('status', true)
                    ->where('from_location', $route->to_location)
                    ->where('to_location', $route->from_location)
                    ->firstOrFail();
                $returnSchedule = Schedule::where('route_id', $returnRoute->id)->where('status', true)->lockForUpdate()->findOrFail($validated['return_schedule_id']);
                $this->ensureCapacity($returnSchedule, $returnDate, $validated['passenger_count'], true);
            }

            $outboundFare = (int) $schedule->price;
            $returnFare = $returnSchedule ? (int) $returnSchedule->price : null;

            return Booking::create([
                'reference' => $this->reference(),
                'route_id' => $route->id,
                'schedule_id' => $schedule->id,
                'travel_date' => $date->toDateString(),
                'return_schedule_id' => $returnSchedule?->id,
                'return_travel_date' => $returnDate?->toDateString(),
                'passenger_count' => $validated['passenger_count'],
                'passenger_name' => $validated['passenger_name'],
                'passenger_email' => $validated['passenger_email'] ?? null,
                'passenger_phone' => $validated['passenger_phone'] ?? null,
                'pickup_point' => $validated['pickup_point'] ?? null,
                'dropoff_point' => $validated['dropoff_point'] ?? null,
                'seat_preference' => $validated['seat_preference'] ?? 'any',
                'notes' => $validated['notes'] ?? null,
                'outbound_fare' => $outboundFare,
                'return_fare' => $returnFare,
                'total_amount' => ($outboundFare + ($returnFare ?? 0)) * $validated['passenger_count'],
                'status' => 'pending',
                'payment_code' => $this->paymentCode(),
                'payment_status' => 'awaiting_payment',
                'locale' => $validated['lang'] ?? 'en',
            ]);
        });

        return redirect()->route('booking.payment.show', ['booking' => $booking, 'lang' => $booking->locale]);
    }

    public function storeLive(Request $request)
    {
        $validated = $request->validate([
            'route_id' => 'required|integer|exists:routes,id',
            'trip_code' => 'required|string|max:100',
            'travel_date' => 'required|date_format:Y-m-d',
            'passenger_count' => 'required|integer|min:1|max:6',
            'passenger_name' => 'required|string|max:120',
            'passenger_email' => 'nullable|email:rfc,dns|max:120|required_without:passenger_phone',
            'passenger_phone' => 'required|string|max:50',
            'pickup_point' => 'nullable|string|max:255',
            'dropoff_point' => 'nullable|string|max:255',
            'seat_preference' => 'nullable|in:any,lower,upper',
            'selected_seats' => 'required|array|min:1|max:6',
            'selected_seats.*' => 'required|string|max:100|distinct',
            'selected_room_options' => 'nullable|array|max:6',
            'selected_room_options.*' => 'required|string|max:1000',
            'notes' => 'nullable|string|max:1500',
            'terms' => 'accepted',
            'lang' => 'nullable|in:vi,en,ru',
        ]);

        $route = BusRoute::where('status', true)->findOrFail($validated['route_id']);
        $date = $this->dateFromRequest($validated['travel_date'], 'travel_date', 'Y-m-d');
        $locale = $validated['lang'] ?? 'en';
        $trip = $this->vexere->findTrip($route->from_location, $route->to_location, $date, $locale, $validated['trip_code']);

        if (!$trip || $trip['available_seats'] < $validated['passenger_count']) {
            throw ValidationException::withMessages(['trip_code' => 'This departure is no longer available.']);
        }

        $tripDetails = $this->vexere->tripDetails($route->from_location, $route->to_location, $trip['code'], $locale);
        $seatMap = $tripDetails['coaches'];
        $selectedSeats = array_values($validated['selected_seats']);
        $seatDetails = collect($seatMap)->flatMap(fn (array $coach) => $coach['seats'])->keyBy('key');
        $availableSeatKeys = $this->availableSeatKeys($seatMap);
        $invalidSeat = collect($selectedSeats)->contains(fn (string $seat) => !in_array($seat, $availableSeatKeys, true));
        if (count(array_unique($selectedSeats)) !== count($selectedSeats) || $invalidSeat) {
            throw ValidationException::withMessages(['selected_seats' => 'Please select available rooms.']);
        }

        $pickupPoint = $this->pointByKey($tripDetails['pickup_points'], $validated['pickup_point'], $validated['passenger_count']);
        $dropoffPoint = $this->pointByKey($tripDetails['dropoff_points'], $validated['dropoff_point'], $validated['passenger_count']);
        if (!$pickupPoint || !$dropoffPoint) {
            throw ValidationException::withMessages(['pickup_point' => 'Please select a valid pickup and drop-off point.']);
        }

        $onlineInfo = $tripDetails['online_info'] ?? [];
        if (!is_numeric($onlineInfo['trip_id'] ?? null) || !is_numeric($trip['booking_from_id'] ?? null) || !is_numeric($trip['booking_to_id'] ?? null)) {
            throw ValidationException::withMessages(['trip_code' => 'The live provider did not return the canonical booking identifiers required to book this departure.']);
        }

        if (!$trip['departure'] instanceof Carbon) {
            throw ValidationException::withMessages(['trip_code' => 'The live provider did not return a valid departure time.']);
        }

        if (!filled($pickupPoint['provider_name'] ?? null) || !filled($pickupPoint['provider_address'] ?? null)
            || !filled($pickupPoint['provider_id'] ?? null) || !filled($pickupPoint['pickup_info'] ?? null)) {
            throw ValidationException::withMessages(['pickup_point' => 'The selected pickup point is missing canonical provider details.']);
        }

        if (!filled($dropoffPoint['provider_address'] ?? null) || !filled($dropoffPoint['dropoff_info'] ?? null)) {
            throw ValidationException::withMessages(['dropoff_point' => 'The selected drop-off point is missing canonical provider details.']);
        }

        $apiSeats = [];
        $roomOptionsBySeat = collect($validated['selected_room_options'] ?? [])
            ->map(function (string $option) {
                try {
                    return json_decode($option, true, flags: JSON_THROW_ON_ERROR);
                } catch (\JsonException) {
                    return null;
                }
            })
            ->filter(fn ($option) => is_array($option) && filled($option['seatCode'] ?? null))
            ->keyBy('seatCode');
        foreach ($selectedSeats as $seatKey) {
            $seat = $seatDetails->get($seatKey);
            $seatType = $seat['seat_type'] ?? null;
            if (!$seat || !is_numeric($seatType)) {
                throw ValidationException::withMessages(['selected_seats' => 'A selected seat is missing its canonical provider seat type.']);
            }

            $roomOption = $roomOptionsBySeat->get($seatKey) ?? collect($seat['room_options'] ?? [])->first();
            $roomOption = collect($seat['room_options'] ?? [])->first(fn (array $option) => (int) ($option['id'] ?? 0) === (int) ($roomOption['id'] ?? 0));
            if (!$roomOption || !is_numeric($roomOption['id'] ?? null) || !filled($roomOption['code'] ?? null)) {
                throw ValidationException::withMessages(['selected_seats' => 'A selected room is missing its provider room type.']);
            }

            $apiSeats[] = [
                'seatCode' => $seatKey,
                'seatType' => (int) $seatType,
                'seatGroupId' => (int) $roomOption['id'],
                'seatGroupCode' => $roomOption['code'],
                'seatGroupName' => $roomOption['name'],
                'customerAmount' => (int) ($roomOption['customer_amount'] ?? 1),
            ];
        }

        if (collect($apiSeats)->sum('customerAmount') !== (int) $validated['passenger_count']) {
            throw ValidationException::withMessages(['selected_seats' => 'Please select room options for exactly the number of passengers.']);
        }

        $departure = $trip['departure'];
        $providerTripDeparture = $trip['provider_trip_departure'] ?? $departure;
        $orderPayload = [
            'tripId' => (int) $onlineInfo['trip_id'],
            'fromId' => (int) $trip['booking_from_id'],
            'toId' => (int) $trip['booking_to_id'],
            'seats' => $apiSeats,
            'customerName' => $validated['passenger_name'],
            'customerPhone' => $validated['passenger_phone'],
            'departureDate' => $departure->toDateString(),
            'departureTime' => $departure->format('H:i'),
            'tripDate' => $providerTripDeparture->toDateString(),
            'tripTime' => $providerTripDeparture->format('H:i'),
            'pickupName' => $pickupPoint['provider_name'],
            'pickupInfo' => $pickupPoint['pickup_info'],
            'dropOffInfo' => $dropoffPoint['dropoff_info'],
        ];
        if (filled($validated['passenger_email'] ?? null)) {
            $orderPayload['customerEmail'] = $validated['passenger_email'];
        }
        if (filled($dropoffPoint['dropoff_time'] ?? null)) {
            $orderPayload['dropOffTime'] = $dropoffPoint['dropoff_time'];
        }
        if (filled($dropoffPoint['provider_id'] ?? null)) {
            $orderPayload['dropOffPointId'] = $dropoffPoint['provider_id'];
        }

        $reference = $this->reference();
        $idempotencyKey = 'web-live-'.$reference;

        try {
            $booking = DB::transaction(function () use ($route, $trip, $date, $validated, $selectedSeats, $locale, $pickupPoint, $dropoffPoint, $reference, $idempotencyKey) {
                $booking = Booking::create([
                    'reference' => $reference,
                    'route_id' => $route->id,
                    'trip_code' => $trip['code'],
                    'departure_at' => $trip['departure'],
                    'arrival_at' => $trip['arrival'],
                    'vehicle_type' => $trip['vehicle_type'],
                    'travel_date' => $date->toDateString(),
                    'passenger_count' => $validated['passenger_count'],
                    'passenger_name' => $validated['passenger_name'],
                    'passenger_email' => $validated['passenger_email'] ?? null,
                    'passenger_phone' => $validated['passenger_phone'] ?? null,
                    'pickup_point' => $this->pointLabel($pickupPoint),
                    'dropoff_point' => $this->pointLabel($dropoffPoint),
                    'seat_preference' => $validated['seat_preference'] ?? 'any',
                    'selected_seats' => $selectedSeats,
                    'notes' => $validated['notes'] ?? null,
                    // The provider supplies the amount after it has held the selected seats.
                    'outbound_fare' => 0,
                    'total_amount' => 0,
                    'status' => 'external_pending',
                    'payment_code' => $this->paymentCode(),
                    'payment_status' => 'awaiting_external_order',
                    'public_booking_idempotency_key' => $idempotencyKey,
                    'locale' => $locale,
                ]);

                return $booking;
            });
        } catch (QueryException) {
            throw ValidationException::withMessages(['selected_seats' => 'One or more selected seats were just taken. Please choose again.']);
        }

        try {
            $order = $this->publicBooking->createOrder($orderPayload, $idempotencyKey);
        } catch (\Throwable $exception) {
            $booking->update([
                'status' => 'failed',
                'payment_status' => 'external_order_failed',
            ]);
            report($exception);

            throw ValidationException::withMessages(['trip_code' => 'Unable to reserve the selected seats. Please choose another departure or try again.']);
        }

        try {
            DB::transaction(function () use ($booking, $order, $selectedSeats, $trip, $date) {
                BookingSeat::insert(collect($selectedSeats)->map(fn (string $seat) => [
                    'booking_id' => $booking->id,
                    'trip_code' => $trip['code'],
                    'travel_date' => $date->toDateString(),
                    'seat' => $seat,
                    'created_at' => now(),
                    'updated_at' => now(),
                ])->all());

            Booking::lockForUpdate()->findOrFail($booking->id)->update([
                'public_booking_order_id' => $order['order_id'],
                'public_booking_status' => $order['status'],
                'public_booking_ticket_codes' => $order['ticket_codes'],
                'public_booking_codes' => $order['booking_codes'],
                'outbound_fare' => $order['amount'],
                'total_amount' => $order['amount'],
                'currency' => $order['currency'],
                'status' => 'pending',
                'payment_status' => 'awaiting_payment',
            ]);
            });
        } catch (QueryException) {
            $booking->update([
                'status' => 'failed',
                'payment_status' => 'external_order_conflict',
            ]);

            throw ValidationException::withMessages(['selected_seats' => 'One or more selected seats were just taken. Please choose again.']);
        }

        $booking->refresh();

        return redirect()->route('booking.payment.show', ['booking' => $booking, 'lang' => $booking->locale]);
    }

    public function success(Booking $booking)
    {
        $booking->load(['route', 'schedule', 'returnSchedule']);

        return view('booking.success', ['booking' => $booking, 'locale' => $booking->locale]);
    }

    private function searchContext(Request $request): array
    {
        $locale = $this->locale($request);
        $from = $request->string('from_location')->value();
        $to = $request->string('to_location')->value();
        $routeId = $request->integer('route_id');
        $isRoundTrip = $request->boolean('is_round_trip');
        $passengerCount = min(6, max(1, $request->integer('seats', 1)));

        if ($from && $to && $from === $to) {
            throw ValidationException::withMessages(['route' => 'Choose different departure and arrival locations.']);
        }

        $route = $routeId
            ? BusRoute::where('status', true)->find($routeId)
            : BusRoute::where('status', true)->where('from_location', $from)->where('to_location', $to)->first();

        if (!$route) {
            throw ValidationException::withMessages(['route' => 'This route is not available for online booking.']);
        }

        $date = $this->dateFromRequest($request->input('departDate'), 'departDate');
        $returnDate = null;
        if ($isRoundTrip) {
            $returnDate = $this->dateFromRequest($request->input('returnDate'), 'returnDate');
            if ($returnDate->lt($date)) {
                throw ValidationException::withMessages(['returnDate' => 'Return travel cannot be before departure.']);
            }
        }

        return [$route, $date, $returnDate, $passengerCount, $locale];
    }

    private function checkoutContext(Request $request): array
    {
        $locale = $this->locale($request);
        $route = BusRoute::where('status', true)->findOrFail($request->integer('route_id'));
        $date = $this->dateFromRequest($request->input('travel_date'), 'travel_date', 'Y-m-d');
        $passengerCount = min(6, max(1, $request->integer('passenger_count', 1)));
        $schedule = Schedule::where('route_id', $route->id)->where('status', true)->findOrFail($request->integer('schedule_id'));
        $this->ensureCapacity($schedule, $date, $passengerCount);

        $isRoundTrip = $request->boolean('is_round_trip');
        $returnDate = null;
        $returnSchedules = collect();
        if ($isRoundTrip) {
            $returnDate = $this->dateFromRequest($request->input('return_travel_date'), 'return_travel_date', 'Y-m-d');
            if ($returnDate->lt($date)) {
                throw ValidationException::withMessages(['return_travel_date' => 'Return travel cannot be before departure.']);
            }

            $returnRoute = BusRoute::where('status', true)
                ->where('from_location', $route->to_location)
                ->where('to_location', $route->from_location)
                ->first();
            if (!$returnRoute) {
                throw ValidationException::withMessages(['return_travel_date' => 'No return route is available online.']);
            }

            $returnSchedules = $this->withAvailability(
                Schedule::where('route_id', $returnRoute->id)->where('status', true)->orderBy('departure_time')->get(),
                $returnDate,
                true
            )->filter(fn ($returnSchedule) => $returnSchedule->available_seats === null || $returnSchedule->available_seats >= $passengerCount);
        }

        return compact('route', 'date', 'schedule', 'passengerCount', 'locale', 'isRoundTrip', 'returnDate', 'returnSchedules');
    }

    private function liveCheckoutContext(Request $request): array
    {
        $locale = $this->locale($request);
        $route = BusRoute::where('status', true)->findOrFail($request->integer('route_id'));
        $date = $this->dateFromRequest($request->input('travel_date'), 'travel_date', 'Y-m-d');
        $passengerCount = min(6, max(1, $request->integer('passenger_count', 1)));
        $tripCode = $request->string('trip_code')->value();
        $trip = $this->vexere->findTrip($route->from_location, $route->to_location, $date, $locale, $tripCode);

        if (!$trip || $trip['available_seats'] < $passengerCount) {
            throw ValidationException::withMessages(['trip_code' => 'This departure is no longer available.']);
        }

        return compact('route', 'date', 'passengerCount', 'locale', 'trip');
    }

    private function reservedSeats(string $tripCode, Carbon $date): array
    {
        return BookingSeat::where('trip_code', $tripCode)
            ->whereDate('travel_date', $date)
            ->whereHas('booking', fn ($query) => $query->reserving())
            ->pluck('seat')
            ->all();
    }

    private function syncCancelledProviderBookings(string $tripCode, Carbon $date): void
    {
        Booking::where('trip_code', $tripCode)
            ->whereDate('travel_date', $date)
            ->whereIn('status', ['pending', 'external_pending'])
            ->whereNotNull('public_booking_order_id')
            ->get()
            ->each(function (Booking $booking) {
                try {
                    $order = $this->publicBooking->getOrder((string) $booking->public_booking_order_id);
                } catch (\Throwable $exception) {
                    report($exception);
                    return;
                }

                $status = $order['status'] ?? null;
                $cancelledSeats = collect($order['seats'] ?? [])
                    ->filter(fn (array $seat) => in_array($seat['status'] ?? null, ['CANCELLED'], true))
                    ->pluck('seatCode')
                    ->all();

                if ($cancelledSeats) {
                    $booking->seatReservations()->whereIn('seat', $cancelledSeats)->delete();
                }

                if (in_array($status, ['CANCELLED', 'EXPIRED'], true) || !$booking->seatReservations()->exists()) {
                    $booking->update([
                        'status' => 'failed',
                        'payment_status' => $status === 'EXPIRED' ? 'external_order_expired' : 'external_order_cancelled',
                        'public_booking_status' => $status,
                    ]);
                }
            });
    }

    private function availableSeatKeys(array $seatMap): array
    {
        return collect($seatMap)
            ->flatMap(fn (array $coach) => $coach['seats'])
            ->filter(fn (array $seat) => $seat['available'] && !$seat['locked'])
            ->pluck('key')
            ->all();
    }

    private function pointByKey(array $points, string $key, int $passengerCount): ?array
    {
        return collect($points)->first(fn (array $point) => ($point['key'] === $key || $point['name'] === $key) && (!$point['min_customers'] || $point['min_customers'] <= $passengerCount));
    }

    private function pointLabel(array $point): string
    {
        return trim($point['name'].($point['address'] ? ' - '.$point['address'] : ''));
    }

    private function withAvailability($schedules, Carbon $date, bool $returnLeg = false)
    {
        $ids = $schedules->pluck('id');
        if ($ids->isEmpty()) {
            return $schedules;
        }

        $booked = Booking::reserving()
            ->whereIn($returnLeg ? 'return_schedule_id' : 'schedule_id', $ids)
            ->whereDate($returnLeg ? 'return_travel_date' : 'travel_date', $date)
            ->selectRaw(($returnLeg ? 'return_schedule_id' : 'schedule_id').' as schedule_id, COALESCE(SUM(passenger_count), 0) as reserved')
            ->groupBy($returnLeg ? 'return_schedule_id' : 'schedule_id')
            ->pluck('reserved', 'schedule_id');

        return $schedules->each(function (Schedule $schedule) use ($booked) {
            $capacity = (int) $schedule->seat_count;
            $schedule->available_seats = $capacity > 0 ? max(0, $capacity - (int) ($booked[$schedule->id] ?? 0)) : null;
        });
    }

    private function ensureCapacity(Schedule $schedule, Carbon $date, int $passengerCount, bool $returnLeg = false): void
    {
        $capacity = (int) $schedule->seat_count;
        if ($capacity < 1) {
            return;
        }

        $reserved = Booking::reserving()
            ->where($returnLeg ? 'return_schedule_id' : 'schedule_id', $schedule->id)
            ->whereDate($returnLeg ? 'return_travel_date' : 'travel_date', $date)
            ->sum('passenger_count');

        if ($reserved + $passengerCount > $capacity) {
            throw ValidationException::withMessages(['schedule_id' => 'This departure no longer has enough available seats.']);
        }
    }

    private function dateFromRequest(mixed $value, string $field, string $format = 'd-m-Y'): Carbon
    {
        if (!is_string($value)) {
            throw ValidationException::withMessages([$field => 'Please choose a valid travel date.']);
        }

        try {
            $date = Carbon::createFromFormat($format, $value)->startOfDay();
        } catch (\Throwable) {
            throw ValidationException::withMessages([$field => 'Please choose a valid travel date.']);
        }

        if ($date->isBefore(today())) {
            throw ValidationException::withMessages([$field => 'Please choose a future travel date.']);
        }

        return $date;
    }

    private function locale(Request $request): string
    {
        $locale = $request->string('lang')->lower()->value();

        return in_array($locale, ['vi', 'en', 'ru'], true) ? $locale : 'en';
    }

    private function reference(): string
    {
        do {
            $reference = 'ND-'.now()->format('ymd').'-'.Str::upper(Str::random(7));
        } while (Booking::where('reference', $reference)->exists());

        return $reference;
    }

    private function paymentCode(): string
    {
        do {
            $code = 'ND'.Str::upper(Str::random(8));
        } while (Booking::where('payment_code', $code)->exists());

        return $code;
    }

}
