<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Route as BusRoute;
use App\Models\Schedule;
use App\Services\VexereTripService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function __construct(private VexereTripService $vexere)
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
            'pickup_point' => 'nullable|string|max:255',
            'dropoff_point' => 'nullable|string|max:255',
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
                'locale' => $validated['lang'] ?? 'en',
            ]);
        });

        return redirect()->route('booking.success', ['booking' => $booking, 'lang' => $booking->locale]);
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

}
