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

        SEOMeta::setTitle('Tin Tức');
        SEOMeta::setDescription('Tin tức và bài viết mới nhất từ Nhà Xe Nhật Dương');

        return view('posts.index', compact('posts', 'categories'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', true)
            ->where('published_at', '<=', now())
            ->with('category')
            ->firstOrFail();

        $relatedPosts = Post::where('status', true)
            ->where('published_at', '<=', now())
            ->where('post_category_id', $post->post_category_id)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        $categories = PostCategory::where('status', true)->get();

        SEOMeta::setTitle($post->meta_title ?? $post->title);
        SEOMeta::setDescription($post->meta_description ?? $post->summary);

        return view('posts.show', compact('post', 'relatedPosts', 'categories'));
    }
}
