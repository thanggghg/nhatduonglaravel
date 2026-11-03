<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Post;
use App\Models\Banner;
use App\Models\Contact;
use App\Models\Schedule;
use App\Models\Setting;
use Illuminate\Http\Request;

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
        $adsBookingMode = Setting::adsBookingMode();

        return view('admin.dashboard', compact('stats', 'recentContacts', 'recentPosts', 'adsBookingMode'));
    }

    public function updateAdsBookingMode(Request $request)
    {
        $request->validate([
            'ads_booking_mode' => 'nullable|boolean',
        ]);

        Setting::updateOrCreate(
            ['key' => 'ads_booking_mode'],
            ['value' => $request->boolean('ads_booking_mode') ? '1' : '0', 'type' => 'boolean'],
        );

        return back()->with('success', $request->boolean('ads_booking_mode')
            ? 'Đã bật chế độ chạy quảng cáo.'
            : 'Đã tắt chế độ chạy quảng cáo.');
    }
}
