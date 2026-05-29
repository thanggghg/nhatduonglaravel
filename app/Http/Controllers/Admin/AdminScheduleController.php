<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Route;
use Illuminate\Http\Request;

class AdminScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with('route')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        $routes = Route::where('status', true)->orderBy('name')->get();
        return view('admin.schedules.create', compact('routes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'route_id'       => 'required|exists:routes,id',
            'departure_time' => 'required|date_format:H:i',
            'arrival_time'   => 'nullable|date_format:H:i',
            'vehicle_type'   => 'nullable|string|max:100',
            'seat_count'     => 'nullable|integer|min:1',
            'price'          => 'required|numeric|min:0',
            'sort_order'     => 'integer|min:0',
            'status'         => 'boolean',
        ]);

        $validated['status'] = $request->boolean('status');
        $validated['sort_order'] = $request->input('sort_order', 0);

        Schedule::create($validated);

        return redirect()->route('admin.schedules.index')->with('success', 'Lịch trình đã được tạo!');
    }

    public function edit(string $id)
    {
        $schedule = Schedule::findOrFail($id);
        $routes = Route::where('status', true)->orderBy('name')->get();
        return view('admin.schedules.edit', compact('schedule', 'routes'));
    }

    public function update(Request $request, string $id)
    {
        $schedule = Schedule::findOrFail($id);

        $validated = $request->validate([
            'route_id'       => 'required|exists:routes,id',
            'departure_time' => 'required|date_format:H:i',
            'arrival_time'   => 'nullable|date_format:H:i',
            'vehicle_type'   => 'nullable|string|max:100',
            'seat_count'     => 'nullable|integer|min:1',
            'price'          => 'required|numeric|min:0',
            'sort_order'     => 'integer|min:0',
            'status'         => 'boolean',
        ]);

        $validated['status'] = $request->boolean('status');
        $validated['sort_order'] = $request->input('sort_order', 0);

        $schedule->update($validated);

        return redirect()->route('admin.schedules.index')->with('success', 'Lịch trình đã được cập nhật!');
    }

    public function destroy(string $id)
    {
        Schedule::findOrFail($id)->delete();
        return redirect()->route('admin.schedules.index')->with('success', 'Lịch trình đã được xóa!');
    }
}
