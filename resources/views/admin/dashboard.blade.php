@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<h2 class="fw-bold mb-4 text-gold"><i class="bi bi-speedometer2 me-2"></i>Dashboard</h2>

<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="text-muted small">Total Movies</div>
            <div class="fs-2 fw-bold">{{ $stats['total_movies'] }}</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="text-muted small">Active Movies</div>
            <div class="fs-2 fw-bold text-gold">{{ $stats['active_movies'] }}</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="text-muted small">Total Bookings</div>
            <div class="fs-2 fw-bold">{{ $stats['total_bookings'] }}</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="text-muted small">Total Revenue</div>
            <div class="fs-2 fw-bold text-gold">${{ number_format($stats['total_revenue'], 2) }}</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center py-3" style="border-bottom: 1px solid #2e2e50;">
        <h5 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2"></i>Recent Bookings</h5>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary btn-sm">View All</a>
    </div>
    <div class="card-body p-0">
        @if ($recentBookings->isEmpty())
            <p class="text-muted text-center py-4">No bookings yet.</p>
        @else
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Movie</th>
                        <th>Customer</th>
                        <th>Seats</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Booked</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentBookings as $booking)
                    <tr>
                        <td class="font-monospace text-gold small">{{ $booking->booking_reference }}</td>
                        <td>{{ $booking->showing->movie->title }}</td>
                        <td>{{ $booking->customer_name }}</td>
                        <td>{{ $booking->seats_booked }}</td>
                        <td>${{ number_format($booking->total_price, 2) }}</td>
                        <td>
                            <span class="badge {{ $booking->status === 'confirmed' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td class="text-muted small">{{ $booking->created_at->diffForHumans() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection
