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
        // Hỗ trợ cả flow cũ (route_id trực tiếp) và flow mới (from/to locations)
        $routeId     = $request->input('route_id');
        $fromLoc     = $request->input('from_location');
        $toLoc       = $request->input('to_location');
        $departDate  = $request->input('departDate'); // d-m-Y
        $isRoundTrip = $request->boolean('is_round_trip');
        $returnDate  = $request->input('returnDate'); // d-m-Y nếu khứ hồi
        $seats       = max(1, (int) $request->input('seats', 1));

        // Tìm route: ưu tiên route_id, nếu không có thì tìm theo from/to
        if ($routeId) {
            $route = BusRoute::where('status', true)->findOrFail($routeId);
        } elseif ($fromLoc && $toLoc) {
            $route = BusRoute::where('status', true)
                ->where('from_location', $fromLoc)
                ->where('to_location', $toLoc)
                ->firstOrFail();
        } else {
            abort(404, 'Vui lòng chọn điểm đi và điểm đến');
        }

        // Parse ngày đi
        try {
            $date = Carbon::createFromFormat('d-m-Y', $departDate);
        } catch (\Exception $e) {
            $date = Carbon::today();
        }

        // Parse ngày về (nếu khứ hồi)
        $returnDateObj = null;
        if ($isRoundTrip && $returnDate) {
            try {
                $returnDateObj = Carbon::createFromFormat('d-m-Y', $returnDate);
            } catch (\Exception $e) {
                $returnDateObj = null;
            }
        }

        // Lấy lịch trình cho chuyến đi
        $schedules = Schedule::where('route_id', $route->id)
            ->where('status', true)
            ->orderBy('departure_time')
            ->get();

        // Lấy lịch trình cho chuyến về (nếu khứ hồi)
        $returnSchedules = collect();
        if ($isRoundTrip && $returnDateObj) {
            // Tìm route ngược lại (to_location -> from_location)
            $returnRoute = BusRoute::where('status', true)
                ->where('from_location', $route->to_location)
                ->where('to_location', $route->from_location)
                ->first();

            if ($returnRoute) {
                $returnSchedules = Schedule::where('route_id', $returnRoute->id)
                    ->where('status', true)
                    ->orderBy('departure_time')
                    ->get();
            }
        }

        return view('booking.search', compact(
            'route',
            'schedules',
            'date',
            'isRoundTrip',
            'returnDateObj',
            'returnSchedules',
            'seats'
        ));
    }
}
