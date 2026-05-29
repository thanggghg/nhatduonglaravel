<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class AdminPostCategoryController extends Controller
{
    public function index()
    {
        $categories = PostCategory::withCount('posts')->orderBy('name')->paginate(20);
        return view('admin.post-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.post-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'boolean',
        ]);

        $validated['status'] = $request->boolean('status');

        PostCategory::create($validated);

        return redirect()->route('admin.post-categories.index')->with('success', 'Danh mục đã được tạo!');
    }

    public function edit(string $id)
    {
        $category = PostCategory::findOrFail($id);
        return view('admin.post-categories.edit', compact('category'));
    }

    public function update(Request $request, string $id)
    {
        $category = PostCategory::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'boolean',
        ]);

        $validated['status'] = $request->boolean('status');

        $category->update($validated);

        return redirect()->route('admin.post-categories.index')->with('success', 'Danh mục đã được cập nhật!');
    }

    public function destroy(string $id)
    {
        $category = PostCategory::findOrFail($id);

        if ($category->posts()->count() > 0) {
            return redirect()->route('admin.post-categories.index')
                ->with('error', 'Không thể xóa danh mục đang có bài viết!');
        }

        $category->delete();

        return redirect()->route('admin.post-categories.index')->with('success', 'Danh mục đã được xóa!');
    }
}
