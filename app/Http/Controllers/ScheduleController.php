<?php

namespace App\Http\Controllers;

use App\Support\Seo;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $locale = $this->locale($request);

        $metadata = [
            'vi' => ['Lịch Trình Xe Nhật Dương', 'Khung giờ khởi hành cố định hằng ngày tuyến TP. Hồ Chí Minh - Nha Trang của Nhà xe Nhật Dương.'],
            'en' => ['Nhat Duong Bus Schedule', 'Fixed daily Nhat Duong departure times between Ho Chi Minh City and Nha Trang.'],
            'ru' => ['Расписание автобусов Nhat Duong', 'Фиксированное ежедневное расписание Nhat Duong между Хошимином и Нячангом.'],
        ][$locale];
        Seo::configure($metadata[0], $metadata[1], Seo::route('schedules.index', ['lang' => $locale]), $locale);
        if ($request->filled('date') || $request->filled('route')) {
            SEOMeta::setRobots('noindex, follow');
        }
        $seoAlternates = Seo::alternates('schedules.index');

        return view('schedules.index', compact('locale', 'seoAlternates'));
    }

    private function locale(Request $request): string
    {
        $locale = $request->string('lang')->lower()->value();

        return in_array($locale, ['vi', 'en', 'ru'], true) ? $locale : 'vi';
    }
}
