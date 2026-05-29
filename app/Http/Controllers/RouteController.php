<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\Faq;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;

class RouteController extends Controller
{
    public function index()
    {
        $routes = Route::where('status', true)
            ->latest()
            ->paginate(12);

        SEOMeta::setTitle('Tuyến Đường');
        SEOMeta::setDescription('Danh sách các tuyến đường xe khách của Nhà Xe Nhật Dương');

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
}
