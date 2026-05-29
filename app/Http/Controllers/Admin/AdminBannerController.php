<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminBannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('sort_order')->paginate(20);
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'subtitle'    => 'nullable|string|max:500',
            'image'       => 'nullable|image|max:4096',
            'button_text' => 'nullable|string|max:100',
            'button_url'  => 'nullable|url',
            'position'    => 'nullable|string|max:50',
            'sort_order'  => 'integer|min:0',
            'status'      => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('banners', 'public');
        }

        $validated['status'] = $request->boolean('status');
        $validated['sort_order'] = $request->input('sort_order', 0);

        Banner::create($validated);

        return redirect()->route('admin.banners.index')->with('success', 'Banner đã được tạo!');
    }

    public function edit(string $id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, string $id)
    {
        $banner = Banner::findOrFail($id);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'subtitle'    => 'nullable|string|max:500',
            'image'       => 'nullable|image|max:4096',
            'button_text' => 'nullable|string|max:100',
            'button_url'  => 'nullable|url',
            'position'    => 'nullable|string|max:50',
            'sort_order'  => 'integer|min:0',
            'status'      => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            $validated['image'] = $request->file('image')->store('banners', 'public');
        }

        $validated['status'] = $request->boolean('status');
        $validated['sort_order'] = $request->input('sort_order', 0);

        $banner->update($validated);

        return redirect()->route('admin.banners.index')->with('success', 'Banner đã được cập nhật!');
    }

    public function destroy(string $id)
    {
        $banner = Banner::findOrFail($id);

        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner đã được xóa!');
    }
}
