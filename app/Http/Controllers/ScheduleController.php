<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Route;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = Schedule::where('status', true)->with('route');

        if ($request->has('route_id')) {
            $query->where('route_id', $request->route_id);
        }

        $schedules = $query->orderBy('departure_time')->get();
        $routes = Route::where('status', true)->get();

        SEOMeta::setTitle('Lịch Trình');
        SEOMeta::setDescription('Bảng lịch trình tham khảo các tuyến xe của Nhà Xe Nhật Dương');

        return view('schedules.index', compact('schedules', 'routes'));
    }
}
