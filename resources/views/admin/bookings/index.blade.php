@extends('layouts.admin')

@section('title', 'Bookings')

@section('content')
<h2 class="fw-bold text-gold mb-4"><i class="bi bi-ticket-perforated me-2"></i>All Bookings</h2>

<div class="card">
    <div class="card-body p-0">
        @if ($bookings->isEmpty())
            <p class="text-muted text-center py-5">No bookings yet.</p>
        @else
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Movie</th>
                        <th>Showing</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Seats</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Booked At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                    <tr>
                        <td class="font-monospace text-gold small">{{ $booking->booking_reference }}</td>
                        <td class="fw-semibold">{{ $booking->showing->movie->title }}</td>
                        <td class="text-muted small">{{ $booking->showing->show_time->format('M d, Y g:i A') }}</td>
                        <td>{{ $booking->customer_name }}</td>
                        <td class="text-muted small">{{ $booking->customer_email }}</td>
                        <td>{{ $booking->seats_booked }}</td>
                        <td>${{ number_format($booking->total_price, 2) }}</td>
                        <td>
                            <span class="badge {{ $booking->status === 'confirmed' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td class="text-muted small">{{ $booking->created_at->format('M d, Y g:i A') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3 d-flex justify-content-end">
            {{ $bookings->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
