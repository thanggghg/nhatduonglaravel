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
        $query = Post::where('status', true)
            ->where('published_at', '<=', now())
            ->with('category');

        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $posts = $query->latest('published_at')->paginate(12);
        $categories = PostCategory::where('status', true)->get();

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
        $post = Post::where('slug', $slug)
            ->where('status', true)
            ->where('published_at', '<=', now())
            ->with('category')
            ->firstOrFail();

        $relatedPosts = Post::where('status', true)
            ->where('published_at', '<=', now())
            ->where('post_category_id', $post->post_category_id)
            ->where('id', '!=', $post->id)
            ->with('category')
            ->latest('published_at')
            ->take(3)
            ->get();

        $categories = PostCategory::where('status', true)->get();

        SEOMeta::setTitle($post->meta_title ?? $post->title);
        SEOMeta::setDescription($post->meta_description ?? $post->summary);

        return view('posts.show', compact('post', 'relatedPosts', 'categories', 'locale'));
    }

    private function locale(Request $request): string
    {
        $locale = $request->string('lang')->lower()->value();

        return in_array($locale, ['vi', 'en', 'ru'], true) ? $locale : 'en';
    }
}
