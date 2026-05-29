<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use Illuminate\Http\Request;

class AdminRouteController extends Controller
{
    public function index()
    {
        $routes = Route::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.routes.index', compact('routes'));
    }

    public function create()
    {
        return view('admin.routes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'from_location' => 'required|string|max:255',
            'to_location' => 'required|string|max:255',
            'distance' => 'nullable|string|max:50',
            'estimated_time' => 'nullable|string|max:50',
            'price_from' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'booking_url' => 'nullable|url',
            'status' => 'boolean',
        ]);

        Route::create($validated);

        return redirect()->route('admin.routes.index')->with('success', 'Tuyến xe đã được tạo thành công!');
    }

    public function show(string $id)
    {
        $route = Route::with(['schedules', 'pickupPoints', 'dropoffPoints'])->findOrFail($id);
        return view('admin.routes.show', compact('route'));
    }

    public function edit(string $id)
    {
        $route = Route::findOrFail($id);
        return view('admin.routes.edit', compact('route'));
    }

    public function update(Request $request, string $id)
    {
        $route = Route::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'from_location' => 'required|string|max:255',
            'to_location' => 'required|string|max:255',
            'distance' => 'nullable|string|max:50',
            'estimated_time' => 'nullable|string|max:50',
            'price_from' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'booking_url' => 'nullable|url',
            'status' => 'boolean',
        ]);

        $route->update($validated);

        return redirect()->route('admin.routes.index')->with('success', 'Tuyến xe đã được cập nhật!');
    }

    public function destroy(string $id)
    {
        $route = Route::findOrFail($id);
        $route->delete();

        return redirect()->route('admin.routes.index')->with('success', 'Tuyến xe đã được xóa!');
    }
}
