<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Faq;
use App\Models\Post;
use App\Models\Route;
use App\Models\Setting;
use App\Services\VexereTripService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(private VexereTripService $vexere)
    {
    }

    public function index(Request $request)
    {
        $locale = $this->locale($request);

        return view('home-new', $this->homeData($locale) + compact('locale'));
    }

    public function homeNew(Request $request)
    {
        return redirect()->route('home', ['lang' => $this->locale($request)]);
    }

    private function locale(Request $request): string
    {
        $locale = $request->string('lang')->lower()->value();

        return in_array($locale, ['vi', 'en', 'ru'], true) ? $locale : 'vi';
    }

    private function homeData(string $locale): array
    {
        $banners = Banner::where('status', true)
            ->orderBy('sort_order')
            ->get();

        $featuredRoutes = Route::where('status', true)
            ->where(function ($q) {
                $q->where('to_location', 'like', '%Nha Trang%')
                  ->orWhere('name', 'like', '%Nha Trang%');
            })
            ->latest()
            ->take(6)
            ->get();

        $latestPosts = Post::where('locale', $locale)
            ->where('status', true)
            ->where('published_at', '<=', now())
            ->with('category')
            ->latest('published_at')
            ->take(3)
            ->get();

        $homeRoutes = Route::where('status', true)
            ->where(function ($query) {
                $query->where(function ($direction) {
                    $direction->where('from_location', 'TP. Hồ Chí Minh')->where('to_location', 'Nha Trang');
                })->orWhere(function ($direction) {
                    $direction->where('from_location', 'Nha Trang')->where('to_location', 'TP. Hồ Chí Minh');
                });
            })
            ->with([
                'pickupPoints' => fn ($query) => $query->orderBy('sort_order'),
                'dropoffPoints' => fn ($query) => $query->orderBy('sort_order'),
            ])
            ->get()
            ->mapWithKeys(fn (Route $route) => [
                $route->from_location === 'Nha Trang' ? 'nt_sg' : 'sg_nt' => $route,
            ]);
        $ntRoute = $homeRoutes->get('sg_nt');
        $liveTravelDate = today()->addDays(2);

        $cacheKey = 'home.schedules:'.$locale.':'.$liveTravelDate->toDateString();
        $liveSchedulesByRoute = Cache::get($cacheKey);
        if (is_array($liveSchedulesByRoute)) {
            foreach ($liveSchedulesByRoute as $direction => &$schedules) {
                foreach ($schedules as &$schedule) {
                    if (!empty($schedule['departure_string'])) {
                        $schedule['departure'] = \Carbon\Carbon::parse($schedule['departure_string'], 'Asia/Ho_Chi_Minh');
                    }
                    if (!empty($schedule['arrival_string'])) {
                        $schedule['arrival'] = \Carbon\Carbon::parse($schedule['arrival_string'], 'Asia/Ho_Chi_Minh');
                    }
                    if (!empty($schedule['provider_trip_departure_string'])) {
                        $schedule['provider_trip_departure'] = \Carbon\Carbon::parse($schedule['provider_trip_departure_string'], 'Asia/Ho_Chi_Minh');
                    }
                    unset($schedule['departure_string'], $schedule['arrival_string'], $schedule['provider_trip_departure_string']);
                }
                unset($schedule);
            }
            unset($schedules);
            $liveSchedules = $liveSchedulesByRoute['sg_nt'] ?? [];
        } else {
            try {
                $liveSchedulesByRoute = $this->vexere->searchMany([
                    'sg_nt' => ['from' => 'TP. Hồ Chí Minh', 'to' => 'Nha Trang'],
                    'nt_sg' => ['from' => 'Nha Trang', 'to' => 'TP. Hồ Chí Minh'],
                ], $liveTravelDate, $locale);
                $liveSchedulesByRoute = collect($liveSchedulesByRoute)->mapWithKeys(fn (array $trips, string $direction) => [
                    $direction => $this->homeTrips($trips, $homeRoutes->get($direction), $locale),
                ])->all();
                $liveSchedules = $liveSchedulesByRoute['sg_nt'] ?? [];

                $toCache = collect($liveSchedulesByRoute)->map(fn ($schedules) => collect($schedules)->map(fn ($trip) => [
                    ...$trip,
                    'departure_string' => $trip['departure']?->toIso8601String(),
                    'arrival_string' => $trip['arrival']?->toIso8601String(),
                    'provider_trip_departure_string' => $trip['provider_trip_departure']?->toIso8601String(),
                    'departure' => null,
                    'arrival' => null,
                    'provider_trip_departure' => null,
                ])->all())->all();
                Cache::put($cacheKey, $toCache, now()->addMinutes(15));
            } catch (\Throwable $exception) {
                report($exception);
                $liveSchedules = [];
                $liveSchedulesByRoute = ['sg_nt' => [], 'nt_sg' => []];
            }
        }

        $faqs = Faq::where('status', true)
            ->orderBy('sort_order')
            ->take(5)
            ->get();

        $settings = Setting::pluck('value', 'key');

        return compact('banners', 'featuredRoutes', 'latestPosts', 'liveSchedules', 'liveSchedulesByRoute', 'liveTravelDate', 'homeRoutes', 'faqs', 'ntRoute', 'settings');
    }

    private function homeTrips(array $trips, ?Route $route, string $locale): array
    {
        if (!$route) {
            return [];
        }

        return Collection::make($trips)
            ->filter(fn (array $trip) => ($trip['fare'] ?? 0) > 0
                && ($trip['available_seats'] ?? 0) > 0
                && filled($trip['code'] ?? null))
            ->sortBy('departure')
            ->unique(fn (array $trip) => implode('|', [
                $trip['departure']->format('H:i'),
                $trip['vehicle_type'] ?? '',
                $trip['fare'],
            ]))
            ->map(fn (array $trip) => $trip + [
                'checkout_url' => route('booking.live.checkout', [
                    'route_id' => $route->id,
                    'trip_code' => $trip['code'],
                    'travel_date' => $trip['departure']->toDateString(),
                    'passenger_count' => 1,
                    'lang' => $locale,
                ], false),
            ])
            ->values()
            ->all();
    }
}
