<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Faq;
use App\Models\Post;
use App\Models\Route;
use App\Models\Schedule;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
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
            })->first();

        $popularSchedules = Schedule::where('status', true)
            ->when($ntRoute, fn($q) => $q->where('route_id', $ntRoute->id))
            ->with('route')
            ->orderBy('departure_time')
            ->get();

        $faqs = Faq::where('status', true)
            ->orderBy('sort_order')
            ->take(5)
            ->get();

        return view('home', compact('banners', 'featuredRoutes', 'latestPosts', 'popularSchedules', 'faqs', 'ntRoute'));
    }
}
