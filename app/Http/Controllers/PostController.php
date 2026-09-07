<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $locale = $this->locale($request);
        $requestedCategory = $request->string('category')->value();

        if ($requestedCategory && !PostCategory::where('slug', $requestedCategory)
            ->whereHas('posts', fn ($query) => $query
                ->where('locale', $locale)
                ->where('status', true)
                ->where('published_at', '<=', now()))
            ->exists()) {
            return redirect()->route('posts.index', ['lang' => $locale]);
        }

        $query = Post::where('locale', $locale)
            ->where('status', true)
            ->where('published_at', '<=', now())
            ->with('category');

        if ($requestedCategory) {
            $query->whereHas('category', function ($q) use ($requestedCategory) {
                $q->where('slug', $requestedCategory);
            });
        }

        $posts = $query->latest('published_at')->paginate(12)->withQueryString();
        $categories = $this->categoriesWithPublishedPosts($locale);

        $metadata = [
            'vi' => ['Tin Tức', 'Tin tức, ưu đãi và hướng dẫn di chuyển từ Nhà Xe Nhật Dương.'],
            'en' => ['Travel Journal', 'News, offers, and travel guidance from Nhat Duong.'],
            'ru' => ['Новости и статьи', 'Новости, предложения и советы для поездок с Nhat Duong.'],
        ][$locale];
        SEOMeta::setTitle($metadata[0]);
        SEOMeta::setDescription($metadata[1]);

        return view('posts.index', compact('posts', 'categories', 'locale'));
    }

    public function show(Request $request, string $slug)
    {
        $locale = $this->locale($request);
        $post = Post::where('locale', $locale)
            ->where('slug', $slug)
            ->where('status', true)
            ->where('published_at', '<=', now())
            ->with('category')
            ->first();

        if (!$post) {
            $sourcePost = Post::where('slug', $slug)->first();
            if ($sourcePost) {
                $baseSlug = preg_replace('/-(en|ru)$/', '', $sourcePost->slug);
                $translatedSlug = $locale === 'vi' ? $baseSlug : $baseSlug.'-'.$locale;
                $translation = Post::where('locale', $locale)
                    ->where('slug', $translatedSlug)
                    ->where('status', true)
                    ->where('published_at', '<=', now())
                    ->first();

                if ($translation) {
                    return redirect()->route('posts.show', ['slug' => $translation->slug, 'lang' => $locale]);
                }
            }

            abort(404);
        }

        $relatedPosts = Post::where('locale', $locale)
            ->where('status', true)
            ->where('published_at', '<=', now())
            ->where('post_category_id', $post->post_category_id)
            ->where('id', '!=', $post->id)
            ->with('category')
            ->latest('published_at')
            ->take(3)
            ->get();

        $categories = $this->categoriesWithPublishedPosts($locale);

        SEOMeta::setTitle($post->meta_title ?? $post->title);
        SEOMeta::setDescription($post->meta_description ?? $post->summary);

        return view('posts.show', compact('post', 'relatedPosts', 'categories', 'locale'));
    }

    private function locale(Request $request): string
    {
        $locale = $request->string('lang')->lower()->value();

        return in_array($locale, ['vi', 'en', 'ru'], true) ? $locale : 'vi';
    }

    private function categoriesWithPublishedPosts(string $locale)
    {
        return PostCategory::where('status', true)
            ->whereHas('posts', fn ($query) => $query
                ->where('locale', $locale)
                ->where('status', true)
                ->where('published_at', '<=', now()))
            ->orderBy('name')
            ->get();
    }
}
