<?php

namespace App\Http\Controllers;

use App\Models\BookingClickLog;
use App\Models\Route;
use Illuminate\Http\Request;

class BookingRedirectController extends Controller
{
    public function redirect(Request $request)
    {
        $routeId = $request->input('route_id');
        $bookingUrl = $request->input('booking_url');
        $sourcePage = $request->input('source_page', 'unknown');

        // Log booking click
        BookingClickLog::create([
            'route_id' => $routeId,
            'source_page' => $sourcePage,
            'booking_url' => $bookingUrl,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Redirect to booking URL
        return redirect()->away($bookingUrl);
    }

    public function index()
    {
        $routes = Route::where('status', true)
            ->whereNotNull('booking_url')
            ->get();

        return view('booking.index', compact('routes'));
    }
}
