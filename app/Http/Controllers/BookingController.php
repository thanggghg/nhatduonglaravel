<?php

namespace App\Http\Controllers;

use App\Models\Route as BusRoute;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function search(Request $request)
    {
        $routeId    = $request->input('route_id');
        $departDate = $request->input('departDate'); // d-m-Y

        // Tìm route
        $route = BusRoute::where('status', true)->findOrFail($routeId);

        // Parse ngày
        try {
            $date = Carbon::createFromFormat('d-m-Y', $departDate);
        } catch (\Exception $e) {
            $date = Carbon::today();
        }

        // Lấy lịch trình theo route, lọc theo giờ trong ngày
        $schedules = Schedule::where('route_id', $routeId)
            ->where('status', true)
            ->orderBy('departure_time')
            ->get();

        return view('booking.search', compact('route', 'schedules', 'date'));
    }
}
