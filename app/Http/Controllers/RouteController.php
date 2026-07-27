<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\Faq;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\JsonLdMulti;

class RouteController extends Controller
{
    public function index(Request $request)
    {
        $routes = Route::where('status', true)
            ->latest()
            ->paginate(12);

        $locale = $this->locale($request);
        $metadata = [
            'vi' => ['Tuyến Đường', 'Các tuyến xe giường nằm của Nhà Xe Nhật Dương.'],
            'en' => ['Bus Routes', 'Explore Nhat Duong sleeper-bus routes in southern Vietnam.'],
            'ru' => ['Автобусные маршруты', 'Маршруты спальных автобусов Nhat Duong на юге Вьетнама.'],
        ][$locale];

        SEOMeta::setTitle($metadata[0]);
        SEOMeta::setDescription($metadata[1]);
        OpenGraph::setTitle($metadata[0]);
        OpenGraph::setDescription($metadata[1]);
        JsonLd::setTitle($metadata[0]);
        JsonLd::setDescription($metadata[1]);
        JsonLdMulti::setTitle($metadata[0]);
        JsonLdMulti::setDescription($metadata[1]);

        return view('routes.index', compact('routes'));
    }

    public function show($slug)
    {
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

        SEOMeta::setTitle($route->meta_title ?? $route->name);
        SEOMeta::setDescription($route->meta_description ?? $route->description);

        return view('routes.show', compact('route', 'schedules', 'pickupPoints', 'dropoffPoints', 'faqs'));
    }

    private function locale(Request $request): string
    {
        $locale = $request->string('lang')->lower()->value();

        return in_array($locale, ['vi', 'en', 'ru'], true) ? $locale : 'en';
    }
}
