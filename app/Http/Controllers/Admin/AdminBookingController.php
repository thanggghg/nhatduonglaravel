<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->string('status')->value();

        $bookings = Booking::with(['route', 'schedule', 'returnSchedule'])
            ->when(in_array($status, ['pending', 'confirmed', 'cancelled'], true), fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(25)
            ->withQueryString();

        return view('admin.bookings.index', compact('bookings', 'status'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $booking->update($validated);
        if ($booking->status === 'cancelled') {
            $booking->seatReservations()->delete();
        }

        return back()->with('success', 'Booking status updated.');
    }
}
