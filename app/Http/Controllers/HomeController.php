<?php

namespace App\Http\Controllers;

use App\Models\Banner;
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
            ->latest()
            ->take(6)
            ->get();

        $latestPosts = Post::where('status', true)
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->take(4)
            ->get();

        $popularSchedules = Schedule::where('status', true)
            ->with('route')
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        return view('home', compact('banners', 'featuredRoutes', 'latestPosts', 'popularSchedules'));
    }
}
