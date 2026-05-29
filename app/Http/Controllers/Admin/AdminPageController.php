<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class AdminPageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('title')->paginate(20);
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'content'          => 'required|string',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'status'           => 'boolean',
        ]);

        $validated['status'] = $request->boolean('status');

        Page::create($validated);

        return redirect()->route('admin.pages.index')->with('success', 'Trang đã được tạo!');
    }

    public function edit(string $id)
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, string $id)
    {
        $page = Page::findOrFail($id);

        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'content'          => 'required|string',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'status'           => 'boolean',
        ]);

        $validated['status'] = $request->boolean('status');

        $page->update($validated);

        return redirect()->route('admin.pages.index')->with('success', 'Trang đã được cập nhật!');
    }

    public function destroy(string $id)
    {
        Page::findOrFail($id)->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Trang đã được xóa!');
    }
}
