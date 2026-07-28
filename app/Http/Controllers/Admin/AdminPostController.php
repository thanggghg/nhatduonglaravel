<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'summary'          => 'nullable|string|max:500',
            'content'          => 'required|string',
            'thumbnail'        => 'nullable|image|max:20480',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'status'           => 'boolean',
            'published_at'     => 'nullable|date',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($post->thumbnail) {
                Storage::disk('public')->delete($post->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('posts', 'public');
        }

        $validated['status'] = $request->boolean('status');
        $validated['content'] = $this->sanitizeContent($validated['content']);

        $post->update($validated);

        return redirect()->route('admin.posts.index')->with('success', 'Bài viết đã được cập nhật!');
    }

    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        if ($post->thumbnail) {
            Storage::disk('public')->delete($post->thumbnail);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Bài viết đã được xóa!');
    }

    private function sanitizeContent(string $content): string
    {
        $document = new \DOMDocument();
        $previousInternalErrors = libxml_use_internal_errors(true);
        $document->loadHTML('<div id="article-content">'.$content.'</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        libxml_use_internal_errors($previousInternalErrors);

        $allowedTags = ['a', 'b', 'blockquote', 'br', 'em', 'h2', 'h3', 'h4', 'li', 'ol', 'p', 'strong', 'u', 'ul'];
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
                if ($element->tagName !== 'a' || !in_array($attribute->name, ['href', 'target', 'rel'], true)) {
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
        }

        $html = '';
        foreach ($container->childNodes as $node) {
            $html .= $document->saveHTML($node);
        }

        return trim($html);
    }
}
