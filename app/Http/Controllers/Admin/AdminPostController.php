<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminPostController extends Controller
{
    public function index(Request $request)
    {
        $locale = $request->string('locale')->lower()->value();
        $posts = Post::with('category')
            ->when(in_array($locale, ['vi', 'en', 'ru'], true), fn ($query) => $query->where('locale', $locale))
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('admin.posts.index', compact('posts', 'locale'));
    }

    public function create()
    {
        $categories = PostCategory::where('status', true)->orderBy('name')->get();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_category_id' => 'required|exists:post_categories,id',
            'locale'           => 'required|in:vi,en,ru',
            'title'            => 'required|string|max:255',
            'summary'          => 'nullable|string|max:500',
            'content'          => 'required|string',
            'thumbnail'        => 'nullable|image|max:20480',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'status'           => 'boolean',
            'published_at'     => 'nullable|date',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('posts', 'public');
        }

        $validated['status'] = $request->boolean('status');
        $validated['published_at'] = $validated['published_at'] ?? now();
        $validated['content'] = $this->sanitizeContent($validated['content']);

        Post::create($validated);

        return redirect()->route('admin.posts.index')->with('success', 'Bài viết đã được tạo thành công!');
    }

    public function show(string $id)
    {
        $post = Post::with('category')->findOrFail($id);
        return view('admin.posts.show', compact('post'));
    }

    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        $categories = PostCategory::where('status', true)->orderBy('name')->get();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'post_category_id' => 'required|exists:post_categories,id',
            'locale'           => 'required|in:vi,en,ru',
            'title'            => 'required|string|max:255',
            'slug'             => ['required', 'string', 'max:255', Rule::unique('posts', 'slug')->ignore($post->id)],
            'summary'          => 'nullable|string|max:500',
            'content'          => 'required|string',
            'thumbnail'        => 'nullable|image|max:20480',
            'remove_thumbnail' => 'nullable|boolean',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'status'           => 'boolean',
            'published_at'     => 'nullable|date',
        ]);

        $oldThumbnail = $post->thumbnail;

        if ($request->boolean('remove_thumbnail')) {
            $validated['thumbnail'] = null;
        }

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('posts', 'public');
        }

        unset($validated['remove_thumbnail']);
        $validated['status'] = $request->boolean('status');
        $validated['content'] = $this->sanitizeContent($validated['content']);

        $post->update($validated);

        if ($oldThumbnail !== $post->thumbnail) {
            $this->deleteThumbnailIfUnused($oldThumbnail);
        }

        return redirect()->route('admin.posts.index')->with('success', 'Bài viết đã được cập nhật!');
    }

    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        $thumbnail = $post->thumbnail;

        $post->delete();

        $this->deleteThumbnailIfUnused($thumbnail);

        return redirect()->route('admin.posts.index')->with('success', 'Bài viết đã được xóa!');
    }

    private function deleteThumbnailIfUnused(?string $thumbnail): void
    {
        if ($thumbnail && ! Post::where('thumbnail', $thumbnail)->exists()) {
            Storage::disk('public')->delete($thumbnail);
        }
    }

    private function sanitizeContent(string $content): string
    {
        $document = new \DOMDocument();
        $previousInternalErrors = libxml_use_internal_errors(true);
        $document->loadHTML('<div id="article-content">'.$content.'</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        libxml_use_internal_errors($previousInternalErrors);

        $allowedTags = ['a', 'b', 'blockquote', 'br', 'em', 'figcaption', 'figure', 'h2', 'h3', 'h4', 'img', 'li', 'ol', 'p', 'strong', 'u', 'ul'];
        $allowedAttributes = [
            'a' => ['href', 'target', 'rel'],
            'img' => ['src', 'alt', 'width', 'height', 'loading'],
        ];
        $container = $document->getElementById('article-content');
        if (!$container) {
            return '';
        }

        foreach (iterator_to_array($container->getElementsByTagName('*')) as $element) {
            if (!in_array($element->tagName, $allowedTags, true)) {
                if (in_array($element->tagName, ['script', 'style'], true)) {
                    $element->parentNode?->removeChild($element);
                    continue;
                }

                while ($element->firstChild) {
                    $element->parentNode?->insertBefore($element->firstChild, $element);
                }
                $element->parentNode?->removeChild($element);
                continue;
            }

            foreach (iterator_to_array($element->attributes) as $attribute) {
                if (!in_array($attribute->name, $allowedAttributes[$element->tagName] ?? [], true)) {
                    $element->removeAttribute($attribute->name);
                }
            }

            if ($element->tagName === 'a') {
                $href = $element->getAttribute('href');
                if ($href && !preg_match('/^(https?:|mailto:|tel:|#|\/)/i', $href)) {
                    $element->removeAttribute('href');
                }
                if ($element->getAttribute('target') === '_blank') {
                    $element->setAttribute('rel', 'noopener noreferrer');
                }
            }

            if ($element->tagName === 'img') {
                $src = $element->getAttribute('src');
                if (!$src || !preg_match('/^(https?:\/\/|\/storage\/)/i', $src)) {
                    $element->parentNode?->removeChild($element);
                    continue;
                }
                $element->setAttribute('loading', 'lazy');
            }
        }

        $html = '';
        foreach ($container->childNodes as $node) {
            $html .= $document->saveHTML($node);
        }

        return trim($html);
    }
}
