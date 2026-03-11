<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Showing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function create(Showing $showing): View
    {
        $showing->load('movie');

        return view('bookings.create', compact('showing'));
    }

    public function store(Request $request, Showing $showing): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name'  => ['required', 'string', 'max:100'],
            'customer_email' => ['required', 'email', 'max:150'],
            'customer_phone' => ['nullable', 'string', 'max:20'],
            'seats_booked'   => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        if (! $showing->hasAvailableSeats($validated['seats_booked'])) {
            return back()->withErrors(['seats_booked' => 'Not enough seats available for this showing.'])->withInput();
        }

        $totalPrice = $showing->movie->ticket_price * $validated['seats_booked'];

        $booking = Booking::create([
            'showing_id'     => $showing->id,
            'customer_name'  => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'] ?? null,
            'seats_booked'   => $validated['seats_booked'],
            'total_price'    => $totalPrice,
        ]);

        $showing->decrement('available_seats', $validated['seats_booked']);

        return redirect()->route('bookings.confirmation', $booking)
            ->with('success', 'Booking confirmed!');
    }

    public function confirmation(Booking $booking): View
    {
        $booking->load('showing.movie');

        return view('bookings.confirmation', compact('booking'));
    }
}
