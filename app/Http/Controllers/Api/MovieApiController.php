<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MovieApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Movie::active();

        if ($request->filled('genre')) {
            $query->where('genre', $request->input('genre'));
        }

        if ($request->filled('search')) {
            $term = $request->input('search');
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%");
            });
        }

        $movies = $query->orderByDesc('release_date')->paginate(12);

        return response()->json($movies);
    }

    public function show(Movie $movie): JsonResponse
    {
        abort_if(! $movie->is_active, 404);

        $movie->load(['showings' => function ($q) {
            $q->where('show_time', '>', now())
              ->where('available_seats', '>', 0)
              ->orderBy('show_time');
        }]);

        return response()->json($movie);
    }

    public function genres(): JsonResponse
    {
        $genres = Movie::active()
            ->distinct()
            ->orderBy('genre')
            ->pluck('genre');

        return response()->json($genres);
    }
}
