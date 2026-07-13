<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Faq;
use App\Models\Post;
use App\Models\Route;
use App\Models\Schedule;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        return view('home-new', $this->homeData() + ['locale' => $this->locale($request)]);
    }

    public function homeNew(Request $request)
    {
        return redirect()->route('home', ['lang' => $this->locale($request)]);
    }

    private function locale(Request $request): string
    {
        $locale = $request->string('lang')->lower()->value();

        return in_array($locale, ['vi', 'en', 'ru'], true) ? $locale : 'en';
    }

    private function homeData(): array
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

        $latestPosts = Post::where('status', true)
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->take(4)
            ->get();

        $ntRoute = Route::where('status', true)
            ->where(function ($q) {
                $q->where('to_location', 'like', '%Nha Trang%')
                  ->orWhere('name', 'like', '%Nha Trang%');
            })
            ->with([
                'pickupPoints' => fn ($query) => $query->orderBy('sort_order'),
                'dropoffPoints' => fn ($query) => $query->orderBy('sort_order'),
            ])
            ->first();

        $popularSchedules = Schedule::where('status', true)
            ->when($ntRoute, fn($q) => $q->where('route_id', $ntRoute->id))
            ->with('route')
            ->orderBy('departure_time')
            ->get();

        $faqs = Faq::where('status', true)
            ->orderBy('sort_order')
            ->take(5)
            ->get();

        $settings = Setting::pluck('value', 'key');

        return compact('banners', 'featuredRoutes', 'latestPosts', 'popularSchedules', 'faqs', 'ntRoute', 'settings');
    }
}
