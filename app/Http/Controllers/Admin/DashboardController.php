<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Post;
use App\Models\Banner;
use App\Models\Contact;
use App\Models\Schedule;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'routes' => Route::count(),
            'posts' => Post::count(),
            'banners' => Banner::count(),
            'schedules' => Schedule::count(),
            'contacts' => Contact::where('status', 'pending')->count(),
        ];

        $recentContacts = Contact::latest()->take(5)->get();
        $recentPosts = Post::with('category')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentContacts', 'recentPosts'));
    }
}
