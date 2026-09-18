<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use App\Models\Route as BusRoute;
use App\Support\Seo;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $staticRoutes = ['home', 'routes.index', 'schedules.index', 'posts.index', 'about', 'contact'];
        $urls = collect($staticRoutes)->flatMap(fn (string $name) => collect(['vi', 'en', 'ru'])->map(fn (string $locale) => [
            'loc' => Seo::route($name, ['lang' => $locale]),
            'lastmod' => null,
        ]));

        $urls = $urls->concat(BusRoute::where('status', true)->get(['slug', 'updated_at'])->flatMap(
            fn (BusRoute $route) => collect(['vi', 'en', 'ru'])->map(fn (string $locale) => [
                'loc' => Seo::route('routes.show', ['slug' => $route->slug, 'lang' => $locale]),
                'lastmod' => $route->updated_at?->toAtomString(),
            ])
        ));

        $urls = $urls->concat(Post::where('status', true)
            ->where('published_at', '<=', now())
            ->get(['slug', 'locale', 'updated_at'])
            ->map(fn (Post $post) => [
                'loc' => Seo::route('posts.show', ['slug' => $post->slug, 'lang' => $post->locale]),
                'lastmod' => $post->updated_at?->toAtomString(),
            ]));

        $urls = $urls->concat(Page::where('status', true)
            ->where('slug', '!=', 've-chung-toi')
            ->get(['slug', 'updated_at'])
            ->map(fn (Page $page) => [
                'loc' => Seo::route('pages.show', ['slug' => $page->slug, 'lang' => 'vi']),
                'lastmod' => $page->updated_at?->toAtomString(),
            ]));

        return response()
            ->view('sitemap', ['urls' => $urls->unique('loc')->values()])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
