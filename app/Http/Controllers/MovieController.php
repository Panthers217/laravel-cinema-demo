<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\View\View;

class MovieController extends Controller
{
    public function index(): View
    {
        $movies = Movie::active()
            ->orderBy('release_date', 'desc')
            ->paginate(9);

        return view('movies.index', compact('movies'));
    }

    public function show(Movie $movie): View
    {
        abort_if(! $movie->is_active, 404);

        $showings = $movie->showings()
            ->where('show_time', '>', now())
            ->where('available_seats', '>', 0)
            ->orderBy('show_time')
            ->get();

        return view('movies.show', compact('movie', 'showings'));
    }
}
