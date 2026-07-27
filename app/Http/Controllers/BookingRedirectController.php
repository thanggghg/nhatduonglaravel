<?php

namespace App\Http\Controllers;

use App\Models\BookingClickLog;
use App\Models\Route;
use Illuminate\Http\Request;

class BookingRedirectController extends Controller
{
    public function redirect(Request $request)
    {
        $route = Route::findOrFail($request->integer('route_id'));
        $bookingUrl = $route->booking_url;
        $sourcePage = $request->string('source_page', 'unknown')->limit(100)->value();

        if (!$bookingUrl || $bookingUrl === 'https://example.com/book' || !filter_var($bookingUrl, FILTER_VALIDATE_URL)) {
            return redirect()->route('booking.search', ['route_id' => $route->id])
                ->withErrors(['booking' => 'Online booking is not configured for this route.']);
        }

        // Log booking click
        BookingClickLog::create([
            'route_id' => $route->id,
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
        return redirect()->to(route('home', ['lang' => 'en']).'#booking');
    }
}
