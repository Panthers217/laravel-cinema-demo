<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Movie;
use App\Models\Showing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $stats = [
            'total_movies'   => Movie::count(),
            'active_movies'  => Movie::active()->count(),
            'total_bookings' => Booking::count(),
            'total_revenue'  => Booking::where('status', 'confirmed')->sum('total_price'),
        ];

        $recentBookings = Booking::with('showing.movie')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentBookings'));
    }

    // ── Movies ──────────────────────────────────────────────────────────────

    public function moviesIndex(): View
    {
        $movies = Movie::orderByDesc('created_at')->paginate(15);

        return view('admin.movies.index', compact('movies'));
    }

    public function moviesCreate(): View
    {
        return view('admin.movies.create');
    }

    public function moviesStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:200'],
            'description'      => ['required', 'string'],
            'genre'            => ['required', 'string', 'max:50'],
            'duration_minutes' => ['required', 'integer', 'min:1', 'max:600'],
            'release_date'     => ['required', 'date'],
            'ticket_price'     => ['required', 'numeric', 'min:0.01', 'max:999.99'],
            'poster_url'       => ['nullable', 'url', 'max:500'],
            'total_seats'      => ['required', 'integer', 'min:1', 'max:1000'],
            'is_active'        => ['boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        Movie::create($validated);

        return redirect()->route('admin.movies.index')
            ->with('success', 'Movie added successfully.');
    }

    public function moviesEdit(Movie $movie): View
    {
        return view('admin.movies.edit', compact('movie'));
    }

    public function moviesUpdate(Request $request, Movie $movie): RedirectResponse
    {
        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:200'],
            'description'      => ['required', 'string'],
            'genre'            => ['required', 'string', 'max:50'],
            'duration_minutes' => ['required', 'integer', 'min:1', 'max:600'],
            'release_date'     => ['required', 'date'],
            'ticket_price'     => ['required', 'numeric', 'min:0.01', 'max:999.99'],
            'poster_url'       => ['nullable', 'url', 'max:500'],
            'total_seats'      => ['required', 'integer', 'min:1', 'max:1000'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $movie->update($validated);

        return redirect()->route('admin.movies.index')
            ->with('success', 'Movie updated successfully.');
    }

    public function moviesDestroy(Movie $movie): RedirectResponse
    {
        $movie->delete();

        return redirect()->route('admin.movies.index')
            ->with('success', 'Movie deleted.');
    }

    // ── Showings ─────────────────────────────────────────────────────────────

    public function showingsCreate(Movie $movie): View
    {
        return view('admin.showings.create', compact('movie'));
    }

    public function showingsStore(Request $request, Movie $movie): RedirectResponse
    {
        $validated = $request->validate([
            'show_time'       => ['required', 'date', 'after:now'],
            'hall'            => ['required', 'string', 'max:50'],
            'available_seats' => ['required', 'integer', 'min:1', 'max:' . $movie->total_seats],
        ]);

        $validated['movie_id'] = $movie->id;

        Showing::create($validated);

        return redirect()->route('admin.movies.index')
            ->with('success', 'Showing added successfully.');
    }

    // ── Bookings ─────────────────────────────────────────────────────────────

    public function bookingsIndex(): View
    {
        $bookings = Booking::with('showing.movie')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.bookings.index', compact('bookings'));
    }
}
