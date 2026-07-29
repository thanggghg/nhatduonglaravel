<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Faq;
use App\Models\Post;
use App\Models\Route;
use App\Models\Setting;
use App\Services\VexereTripService;
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

        try {
            $liveSchedulesByRoute = $this->vexere->searchMany([
                'sg_nt' => ['from' => 'TP. Hồ Chí Minh', 'to' => 'Nha Trang'],
                'nt_sg' => ['from' => 'Nha Trang', 'to' => 'TP. Hồ Chí Minh'],
            ], today(), $locale);
            $liveSchedules = $liveSchedulesByRoute['sg_nt'] ?? [];
        } catch (\Throwable $exception) {
            report($exception);
            $liveSchedules = [];
            $liveSchedulesByRoute = ['sg_nt' => [], 'nt_sg' => []];
        }

        $faqs = Faq::where('status', true)
            ->orderBy('sort_order')
            ->take(5)
            ->get();

        $settings = Setting::pluck('value', 'key');

        return compact('banners', 'featuredRoutes', 'latestPosts', 'liveSchedules', 'liveSchedulesByRoute', 'faqs', 'ntRoute', 'settings');
    }
}
