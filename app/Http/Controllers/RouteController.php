<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\Faq;
use App\Support\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RouteController extends Controller
{
    public function index(Request $request)
    {
        $locale = $this->locale($request);
        $routes = Route::where('status', true)
            ->latest()
            ->paginate(12)
            ->appends(['lang' => $locale]);

        $metadata = [
            'vi' => ['Tuyến Đường', 'Các tuyến xe giường nằm của Nhà Xe Nhật Dương.'],
            'en' => ['Bus Routes', 'Explore Nhat Duong sleeper-bus routes in southern Vietnam.'],
            'ru' => ['Автобусные маршруты', 'Маршруты спальных автобусов Nhat Duong на юге Вьетнама.'],
        ][$locale];

        $pageParameters = array_filter([
            'lang' => $locale,
            'page' => $routes->currentPage() > 1 ? $routes->currentPage() : null,
        ]);
        Seo::configure($metadata[0], $metadata[1], Seo::route('routes.index', $pageParameters), $locale);
        $seoAlternates = Seo::alternates('routes.index', array_filter([
            'page' => $routes->currentPage() > 1 ? $routes->currentPage() : null,
        ]));

        return view('routes.index', compact('routes', 'locale', 'seoAlternates'));
    }

    public function show(Request $request, $slug)
    {
        $locale = $this->locale($request);
        $route = Route::where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        $schedules = $route->schedules()
            ->where('status', true)
            ->orderBy('departure_time')
            ->get();

        $pickupPoints = $route->pickupPoints()
            ->where('status', true)
            ->orderBy('sort_order')
            ->get();

        $dropoffPoints = $route->dropoffPoints()
            ->where('status', true)
            ->orderBy('sort_order')
            ->get();

        $faqs = Faq::where('status', true)
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        $title = $route->meta_title ?: $route->name;
        $description = Str::limit(strip_tags($route->meta_description ?: $route->description ?: $route->name), 160);
        Seo::configure(
            $title,
            $description,
            Seo::route('routes.show', ['slug' => $route->slug, 'lang' => $locale]),
            $locale,
            'website',
            'WebPage',
            $route->image ? '/storage/'.$route->image : null,
        );
        $seoAlternates = Seo::alternates('routes.show', ['slug' => $route->slug]);

        return view('routes.show', compact('route', 'schedules', 'pickupPoints', 'dropoffPoints', 'faqs', 'locale', 'seoAlternates'));
    }

    private function locale(Request $request): string
    {
        $locale = $request->string('lang')->lower()->value();

        return in_array($locale, ['vi', 'en', 'ru'], true) ? $locale : 'vi';
    }
}
