<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Support\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function about(Request $request)
    {
        return $this->show($request, 've-chung-toi');
    }

    public function show(Request $request, $slug)
    {
        $page = Page::where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        $locale = $request->string('lang')->lower()->value();
        $locale = in_array($locale, ['vi', 'en', 'ru'], true) ? $locale : 'vi';

        if ($slug === 've-chung-toi') {
            $metadata = [
                'vi' => ['Về Nhà Xe Nhật Dương', 'Tìm hiểu về Nhà Xe Nhật Dương và cam kết cho mỗi hành trình.'],
                'en' => ['About Nhat Duong', 'Learn about Nhat Duong and our commitment to every journey.'],
                'ru' => ['О компании Nhat Duong', 'Узнайте больше о Nhat Duong и нашей заботе о каждой поездке.'],
            ][$locale];
            Seo::configure($metadata[0], $metadata[1], Seo::route('about', ['lang' => $locale]), $locale);
            $seoAlternates = Seo::alternates('about');

            return view('pages.about', compact('page', 'locale', 'seoAlternates'));
        }

        $title = $page->meta_title ?: $page->title;
        $description = Str::limit(strip_tags($page->meta_description ?: $page->content), 160);
        Seo::configure($title, $description, Seo::route('pages.show', ['slug' => $page->slug, 'lang' => 'vi']), 'vi');
        $seoAlternates = ['vi' => Seo::route('pages.show', ['slug' => $page->slug, 'lang' => 'vi'])];

        return view('pages.show', compact('page', 'locale', 'seoAlternates'));
    }
}
