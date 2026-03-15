@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
<section class="py-5">
    <div class="container" style="max-width: 520px;">
        <div class="card shadow-sm">
            <div class="card-body p-4 p-md-5">
                <h1 class="h3 fw-bold mb-2 text-gold">
                    <i class="bi bi-shield-lock-fill me-2"></i>Admin Login
                </h1>
                <p class="text-muted mb-4">Sign in with your Firebase admin account.</p>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('admin.login.attempt') }}" method="POST" class="vstack gap-3">
                    @csrf

                    <div>
                        <label for="email" class="form-label">Admin Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email') }}"
                            required
                            autofocus
                        >
                    </div>

                    <div>
                        <label for="password" class="form-label">Password</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control"
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
