@extends('layouts.app')

@section('title', $movie->title)

@section('content')
<div class="container py-5">
    <a href="{{ route('movies.index') }}" class="btn btn-outline-light btn-sm mb-4">
        <i class="bi bi-arrow-left me-1"></i> Back to Movies
    </a>

    <div class="row g-4">
        {{-- Poster --}}
        <div class="col-md-4">
            @if ($movie->poster_url)
                <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}"
                     class="img-fluid rounded shadow" style="max-height: 500px; width: 100%; object-fit: cover;">
            @else
                <div class="rounded d-flex align-items-center justify-content-center"
                     style="background: #12122a; height: 400px;">
                    <i class="bi bi-camera-reels display-1 text-muted opacity-25"></i>
                </div>
            @endif
        </div>

        {{-- Movie details --}}
        <div class="col-md-8">
            <div class="mb-2">
                <span class="badge badge-genre me-1">{{ $movie->genre }}</span>
                <span class="badge bg-secondary me-1">{{ $movie->duration_minutes }} min</span>
                <span class="badge bg-dark border">Released {{ $movie->release_date->format('M d, Y') }}</span>
            </div>
            <h1 class="fw-bold text-gold">{{ $movie->title }}</h1>
            <p class="lead mt-3">{{ $movie->description }}</p>

            <div class="mt-4 p-3 rounded" style="background: #12122a; border: 1px solid #2e2e50;">
                <span class="text-muted">Ticket Price</span>
                <div class="fs-3 fw-bold text-gold">${{ number_format($movie->ticket_price, 2) }}</div>
            </div>

            {{-- Showings --}}
            <h4 class="mt-4 mb-3 fw-bold"><i class="bi bi-clock me-2"></i>Upcoming Showings</h4>

            @if ($showings->isEmpty())
                <div class="text-muted">
                    <i class="bi bi-calendar-x me-1"></i>
                    No upcoming showings scheduled. Check back later.
                </div>
            @else
                @foreach ($showings as $showing)
                <div class="showing-card d-flex align-items-center justify-content-between">
                    <div>
                        <div class="fw-semibold">
                            <i class="bi bi-calendar3 me-1 text-gold"></i>
                            {{ $showing->show_time->format('D, M d Y') }}
                        </div>
                        <div class="text-muted small">
                            <i class="bi bi-clock me-1"></i>{{ $showing->show_time->format('g:i A') }}
                            &nbsp;&bull;&nbsp;
                            <i class="bi bi-buildings me-1"></i>{{ $showing->hall }}
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="text-muted small mb-1">
                            <i class="bi bi-person-seat me-1"></i>{{ $showing->available_seats }} seats left
                        </div>
                        <a href="{{ route('bookings.create', $showing) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-ticket-perforated me-1"></i> Book
                        </a>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
