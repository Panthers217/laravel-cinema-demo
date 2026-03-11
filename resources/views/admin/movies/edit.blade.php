@extends('layouts.admin')

@section('title', 'Edit Movie')

@section('content')
<div style="max-width: 700px;">
    <a href="{{ route('admin.movies.index') }}" class="btn btn-outline-secondary btn-sm mb-4">
        <i class="bi bi-arrow-left me-1"></i> Back to Movies
    </a>
    <h2 class="fw-bold text-gold mb-4"><i class="bi bi-pencil me-2"></i>Edit Movie</h2>

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

        <form action="{{ route('admin.movies.update', $movie) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.movies._form', ['movie' => $movie])
            <div class="d-flex gap-2 justify-content-end mt-4">
                <a href="{{ route('admin.movies.index') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i> Update Movie
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
