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

        SEOMeta::setTitle($page->meta_title ?? $page->title);
        SEOMeta::setDescription($page->meta_description ?? substr(strip_tags($page->content), 0, 160));

        return view('pages.show', compact('page'));
    }
}
