<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use App\Support\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $locale = $this->locale($request);
        $requestedCategory = $request->string('category')->value();

        $category = $requestedCategory ? PostCategory::where('slug', $requestedCategory)
            ->whereHas('posts', fn ($query) => $query
                ->where('locale', $locale)
                ->where('status', true)
                ->where('published_at', '<=', now()))
            ->first() : null;
        if ($requestedCategory && !$category) {
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
        if ($category) {
            $metadata[0] .= ' - '.$category->name;
        }

        $canonicalParameters = array_filter([
            'lang' => $locale,
            'category' => $category?->slug,
            'page' => $posts->currentPage() > 1 ? $posts->currentPage() : null,
        ]);
        Seo::configure($metadata[0], $metadata[1], Seo::route('posts.index', $canonicalParameters), $locale);
        if ($posts->currentPage() > 1) {
            $seoAlternates = [$locale => Seo::route('posts.index', $canonicalParameters)];
        } elseif ($category) {
            $seoAlternates = Post::where('post_category_id', $category->id)
                ->where('status', true)
                ->where('published_at', '<=', now())
                ->distinct()
                ->pluck('locale')
                ->mapWithKeys(fn (string $language) => [
                    $language => Seo::route('posts.index', ['lang' => $language, 'category' => $category->slug]),
                ])->all();
        } else {
            $seoAlternates = Seo::alternates('posts.index');
        }

        return view('posts.index', compact('posts', 'categories', 'locale', 'seoAlternates'));
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

        // Keep the template title as the single H1 even when imported content contains H1 tags.
        $post->content = preg_replace(['/<h1\b/i', '/<\/h1>/i'], ['<h2', '</h2>'], $post->content);

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

        $title = $post->meta_title ?: $post->title;
        $description = Str::limit(strip_tags($post->meta_description ?: $post->summary ?: $post->content), 160);
        $canonical = Seo::route('posts.show', ['slug' => $post->slug, 'lang' => $locale]);
        $image = $post->thumbnail ? '/storage/'.$post->thumbnail : null;
        Seo::configure($title, $description, $canonical, $locale, 'article', 'Article', $image, [
            'datePublished' => $post->published_at?->toAtomString(),
            'dateModified' => $post->updated_at?->toAtomString(),
            'author' => ['@type' => 'Organization', 'name' => 'Nhà Xe Nhật Dương'],
        ]);

        $baseSlug = preg_replace('/-(en|ru)$/', '', $post->slug);
        $translationSlugs = [$baseSlug, $baseSlug.'-en', $baseSlug.'-ru'];
        $seoAlternates = Post::whereIn('slug', $translationSlugs)
            ->where('status', true)
            ->where('published_at', '<=', now())
            ->get(['slug', 'locale'])
            ->mapWithKeys(fn (Post $translation) => [
                $translation->locale => Seo::route('posts.show', ['slug' => $translation->slug, 'lang' => $translation->locale]),
            ])->all();

        return view('posts.show', compact('post', 'relatedPosts', 'categories', 'locale', 'seoAlternates'));
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
