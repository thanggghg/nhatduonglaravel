<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.posts.index', compact('posts'));
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
            'title'            => 'required|string|max:255',
            'summary'          => 'nullable|string|max:500',
            'content'          => 'required|string',
            'thumbnail'        => 'nullable|image|max:2048',
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
            'title'            => 'required|string|max:255',
            'summary'          => 'nullable|string|max:500',
            'content'          => 'required|string',
            'thumbnail'        => 'nullable|image|max:2048',
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
}
