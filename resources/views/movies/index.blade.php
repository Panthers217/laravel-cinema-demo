@extends('layouts.app')

@section('title', 'Now Showing')

@section('content')
<div class="hero">
    <div class="container text-center">
        <h1 class="fw-bold text-gold display-4"><i class="bi bi-camera-reels-fill me-2"></i>Now Showing</h1>
        <p class="lead text-muted">Book your seat for the best films in town</p>
    </div>
</div>

<div class="container py-5">

    @if ($movies->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-film display-1 text-muted"></i>
            <p class="mt-3 text-muted fs-4">No movies available at the moment.</p>
            <a href="{{ route('admin.movies.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Add a Movie
            </a>
        </div>
    @else
        <div class="row g-4">
            @foreach ($movies as $movie)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    @if ($movie->poster_url)
                        <img src="{{ $movie->poster_url }}" class="card-img-top" alt="{{ $movie->title }}">
                    @else
                        <div class="card-img-top d-flex align-items-center justify-content-center"
                             style="background: #12122a; height: 300px;">
                            <i class="bi bi-camera-reels display-1 text-muted opacity-25"></i>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <div class="mb-2">
                            <span class="badge badge-genre me-1">{{ $movie->genre }}</span>
                            <span class="badge bg-secondary">{{ $movie->duration_minutes }} min</span>
                        </div>
                        <h5 class="card-title fw-bold">{{ $movie->title }}</h5>
                        <p class="card-text text-muted small flex-grow-1">
                            {{ Str::limit($movie->description, 100) }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="text-gold fw-bold fs-5">${{ number_format($movie->ticket_price, 2) }}</span>
                            <a href="{{ route('movies.show', $movie) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-ticket-perforated me-1"></i> Book Now
                            </a>
                        </div>
                    </div>
                    <div class="card-footer text-muted small">
                        <i class="bi bi-calendar3 me-1"></i>
                        Released {{ $movie->release_date->format('M d, Y') }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $movies->links() }}
        </div>
    @endif
</div>
@endsection
