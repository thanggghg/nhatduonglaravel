<?php

namespace App\Http\Controllers;

use App\Services\VexereTripService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;

class ScheduleController extends Controller
{
    public function __construct(private VexereTripService $vexere)
    {
    }

    public function index(Request $request)
    {
        $locale = $this->locale($request);
        $date = $this->date($request);
        $areas = config('services.vexere.areas', []);
        $routes = collect(array_keys($areas))->flatMap(function (string $from) use ($areas) {
            return collect(array_keys($areas))
                ->reject(fn (string $to) => $from === $to)
                ->map(fn (string $to) => [
                    'key' => $areas[$from].'-'.$areas[$to],
                    'from' => $from,
                    'to' => $to,
                ]);
        })->values();

        $selectedRoutes = $request->filled('route')
            ? $routes->where('key', $request->string('route')->value())
            : $routes;

        try {
            $liveTrips = $this->vexere->searchMany(
                $selectedRoutes->mapWithKeys(fn (array $route) => [$route['key'] => [
                    'from' => $route['from'],
                    'to' => $route['to'],
                ]])->all(),
                $date,
                $locale
            );
            $schedules = $selectedRoutes->flatMap(function (array $route) use ($liveTrips) {
                return collect($liveTrips[$route['key']] ?? [])->map(fn (array $trip) => $trip + ['route' => $route]);
            })->sortBy('departure')->values();
            $apiError = false;
        } catch (\Throwable $exception) {
            report($exception);
            $schedules = collect();
            $apiError = true;
        }

        $metadata = [
            'vi' => ['Lịch Trình Trực Tuyến', 'Lịch chạy cập nhật trực tiếp từ hệ thống đặt vé của Nhà Xe Nhật Dương.'],
            'en' => ['Live Departure Schedule', 'Live Nhat Duong departure times and seat availability.'],
            'ru' => ['Актуальное расписание', 'Актуальное расписание и наличие мест Nhat Duong.'],
        ][$locale];
        SEOMeta::setTitle($metadata[0]);
        SEOMeta::setDescription($metadata[1]);

        return view('schedules.index', compact('schedules', 'routes', 'date', 'locale', 'apiError'));
    }

    private function date(Request $request): Carbon
    {
        $value = $request->input('date');
        if (!$value) {
            return today();
        }

        try {
            $date = Carbon::createFromFormat('Y-m-d', $value)->startOfDay();
        } catch (\Throwable) {
            return today();
        }

        return $date->isBefore(today()) ? today() : $date;
    }

    private function locale(Request $request): string
    {
        $locale = $request->string('lang')->lower()->value();

        return in_array($locale, ['vi', 'en', 'ru'], true) ? $locale : 'en';
    }
}
