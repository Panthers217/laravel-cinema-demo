@extends('layouts.admin')

@section('title', 'Movies')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-gold mb-0"><i class="bi bi-film me-2"></i>Movies</h2>
    <a href="{{ route('admin.movies.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Add Movie
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        @if ($movies->isEmpty())
            <p class="text-muted text-center py-5">No movies yet. <a href="{{ route('admin.movies.create') }}">Add one</a>.</p>
        @else
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Genre</th>
                        <th>Duration</th>
                        <th>Release</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($movies as $movie)
                    <tr>
                        <td class="fw-semibold">{{ $movie->title }}</td>
                        <td><span class="badge badge-genre">{{ $movie->genre }}</span></td>
                        <td>{{ $movie->duration_minutes }} min</td>
                        <td>{{ $movie->release_date->format('M d, Y') }}</td>
                        <td>${{ number_format($movie->ticket_price, 2) }}</td>
                        <td>
                            <span class="badge {{ $movie->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $movie->is_active ? 'Active' : 'Hidden' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.showings.create', $movie) }}"
                                   class="btn btn-outline-secondary btn-sm" title="Add Showing">
                                    <i class="bi bi-clock-history"></i>
                                </a>
                                <a href="{{ route('admin.movies.edit', $movie) }}"
                                   class="btn btn-outline-warning btn-sm" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST"
                                      onsubmit="return confirm('Delete this movie?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3 d-flex justify-content-end">
            {{ $movies->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
