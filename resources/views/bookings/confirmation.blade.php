@extends('layouts.app')

@section('title', 'Booking Confirmed!')

@section('content')
<div class="container py-5" style="max-width: 650px;">
    <div class="card p-4 shadow text-center">
        <div class="mb-3">
            <i class="bi bi-check-circle-fill text-gold" style="font-size: 4rem;"></i>
        </div>
        <h1 class="fw-bold text-gold mb-1">Booking Confirmed!</h1>
        <p class="text-muted">Your tickets are reserved. See you at the cinema!</p>

        <hr style="border-color: #2e2e50;">

        <div class="p-3 rounded mb-3" style="background: #12122a; border: 1px solid #f0c040;">
            <div class="text-muted small mb-1">Booking Reference</div>
            <div class="fs-3 fw-bold text-gold font-monospace">{{ $booking->booking_reference }}</div>
        </div>

        <table class="table table-borderless text-start mt-2">
            <tbody>
                <tr>
                    <td class="text-muted" style="width:40%"><i class="bi bi-film me-1"></i>Movie</td>
                    <td class="fw-semibold">{{ $booking->showing->movie->title }}</td>
                </tr>
                <tr>
                    <td class="text-muted"><i class="bi bi-calendar3 me-1"></i>Date &amp; Time</td>
                    <td class="fw-semibold">{{ $booking->showing->show_time->format('D, M d Y \a\t g:i A') }}</td>
                </tr>
                <tr>
                    <td class="text-muted"><i class="bi bi-buildings me-1"></i>Hall</td>
                    <td class="fw-semibold">{{ $booking->showing->hall }}</td>
                </tr>
                <tr>
                    <td class="text-muted"><i class="bi bi-person me-1"></i>Name</td>
                    <td class="fw-semibold">{{ $booking->customer_name }}</td>
                </tr>
                <tr>
                    <td class="text-muted"><i class="bi bi-envelope me-1"></i>Email</td>
                    <td class="fw-semibold">{{ $booking->customer_email }}</td>
                </tr>
                <tr>
                    <td class="text-muted"><i class="bi bi-person-seat me-1"></i>Seats</td>
                    <td class="fw-semibold">{{ $booking->seats_booked }}</td>
                </tr>
                <tr>
                    <td class="text-muted"><i class="bi bi-currency-dollar me-1"></i>Total Paid</td>
                    <td class="fw-bold text-gold fs-5">${{ number_format($booking->total_price, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="d-flex gap-2 justify-content-center mt-3">
            <a href="{{ route('movies.index') }}" class="btn btn-primary">
                <i class="bi bi-film me-1"></i> Browse More Movies
            </a>
        </div>
    </div>
</div>
@endsection
