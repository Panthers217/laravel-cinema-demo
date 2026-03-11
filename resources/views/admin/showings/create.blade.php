@extends('layouts.admin')

@section('title', 'Add Showing')

@section('content')
<div style="max-width: 550px;">
    <a href="{{ route('admin.movies.index') }}" class="btn btn-outline-secondary btn-sm mb-4">
        <i class="bi bi-arrow-left me-1"></i> Back to Movies
    </a>
    <h2 class="fw-bold text-gold mb-1"><i class="bi bi-clock-history me-2"></i>Add Showing</h2>
    <p class="text-muted mb-4">for <strong>{{ $movie->title }}</strong></p>

    <div class="card p-4">
        @if ($errors->any())
            <div class="alert alert-danger mb-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.showings.store', $movie) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="show_time" class="form-label">Date &amp; Time <span class="text-danger">*</span></label>
                <input type="datetime-local" id="show_time" name="show_time"
                       class="form-control @error('show_time') is-invalid @enderror"
                       value="{{ old('show_time') }}" required>
                @error('show_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="hall" class="form-label">Hall <span class="text-danger">*</span></label>
                <select id="hall" name="hall" class="form-select @error('hall') is-invalid @enderror" required>
                    @foreach (['Hall 1', 'Hall 2', 'Hall 3', 'IMAX', 'VIP Lounge'] as $hall)
                        <option value="{{ $hall }}" {{ old('hall') === $hall ? 'selected' : '' }}>
                            {{ $hall }}
                        </option>
                    @endforeach
                </select>
                @error('hall') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label for="available_seats" class="form-label">
                    Available Seats <span class="text-danger">*</span>
                    <span class="text-muted small">(max {{ $movie->total_seats }})</span>
                </label>
                <input type="number" id="available_seats" name="available_seats"
                       min="1" max="{{ $movie->total_seats }}"
                       class="form-control @error('available_seats') is-invalid @enderror"
                       value="{{ old('available_seats', $movie->total_seats) }}" required>
                @error('available_seats') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="d-flex gap-2 justify-content-end">
                <a href="{{ route('admin.movies.index') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i> Add Showing
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
