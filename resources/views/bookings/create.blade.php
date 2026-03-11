@extends('layouts.app')

@section('title', 'Book Tickets — ' . $showing->movie->title)

@section('content')
<div class="container py-5" style="max-width: 650px;">
    <a href="{{ route('movies.show', $showing->movie) }}" class="btn btn-outline-light btn-sm mb-4">
        <i class="bi bi-arrow-left me-1"></i> Back to Movie
    </a>

    <div class="card p-4 shadow">
        {{-- Header --}}
        <div class="mb-4 pb-3" style="border-bottom: 1px solid #2e2e50;">
            <h2 class="fw-bold text-gold">
                <i class="bi bi-ticket-perforated me-2"></i>Book Tickets
            </h2>
            <h5 class="mt-1">{{ $showing->movie->title }}</h5>
            <div class="text-muted small">
                <i class="bi bi-calendar3 me-1"></i>
                {{ $showing->show_time->format('D, M d Y \a\t g:i A') }}
                &nbsp;&bull;&nbsp;
                <i class="bi bi-buildings me-1"></i>{{ $showing->hall }}
                &nbsp;&bull;&nbsp;
                <i class="bi bi-person-seat me-1"></i>{{ $showing->available_seats }} seats available
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger mb-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('bookings.store', $showing) }}" method="POST" novalidate>
            @csrf

            <div class="mb-3">
                <label for="customer_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                <input type="text" id="customer_name" name="customer_name"
                       class="form-control @error('customer_name') is-invalid @enderror"
                       value="{{ old('customer_name') }}" placeholder="Jane Smith" required>
                @error('customer_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="customer_email" class="form-label">Email Address <span class="text-danger">*</span></label>
                <input type="email" id="customer_email" name="customer_email"
                       class="form-control @error('customer_email') is-invalid @enderror"
                       value="{{ old('customer_email') }}" placeholder="jane@example.com" required>
                @error('customer_email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="customer_phone" class="form-label">Phone <span class="text-muted">(optional)</span></label>
                <input type="tel" id="customer_phone" name="customer_phone"
                       class="form-control @error('customer_phone') is-invalid @enderror"
                       value="{{ old('customer_phone') }}" placeholder="+1 555 000 0000">
                @error('customer_phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="seats_booked" class="form-label">Number of Seats <span class="text-danger">*</span></label>
                <select id="seats_booked" name="seats_booked"
                        class="form-select @error('seats_booked') is-invalid @enderror" required>
                    @for ($i = 1; $i <= min(10, $showing->available_seats); $i++)
                        <option value="{{ $i }}" {{ old('seats_booked', 1) == $i ? 'selected' : '' }}>
                            {{ $i }} seat{{ $i > 1 ? 's' : '' }} — ${{ number_format($showing->movie->ticket_price * $i, 2) }}
                        </option>
                    @endfor
                </select>
                @error('seats_booked')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-check-circle me-2"></i>Confirm Booking
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
