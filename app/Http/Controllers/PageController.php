<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        $locale = request()->string('lang')->lower()->value();
        $locale = in_array($locale, ['vi', 'en', 'ru'], true) ? $locale : 'en';

        if ($slug === 've-chung-toi') {
            $metadata = [
                'vi' => ['Về Nhà Xe Nhật Dương', 'Tìm hiểu về Nhà Xe Nhật Dương và cam kết cho mỗi hành trình.'],
                'en' => ['About Nhat Duong', 'Learn about Nhat Duong and our commitment to every journey.'],
                'ru' => ['О компании Nhat Duong', 'Узнайте больше о Nhat Duong и нашей заботе о каждой поездке.'],
            ][$locale];
            SEOMeta::setTitle($metadata[0]);
            SEOMeta::setDescription($metadata[1]);

            return view('pages.about', compact('page', 'locale'));
        }

        SEOMeta::setTitle($page->meta_title ?? $page->title);
        SEOMeta::setDescription($page->meta_description ?? substr(strip_tags($page->content), 0, 160));

        return view('pages.show', compact('page', 'locale'));
    }
}
