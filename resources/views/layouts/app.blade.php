<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CinemaTickets') — Cinema Tickets</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #0f0f1a; color: #e8e8f0; }
        .navbar-brand { font-weight: 700; font-size: 1.4rem; color: #f0c040 !important; }
        .navbar { background-color: #16162a !important; border-bottom: 2px solid #f0c040; }
        .navbar-nav .nav-link { color: #ccc !important; }
        .navbar-nav .nav-link:hover { color: #f0c040 !important; }
        .card { background-color: #1c1c35; border: 1px solid #2e2e50; color: #e8e8f0; }
        .card-img-top { height: 300px; object-fit: cover; }
        .badge-genre { background-color: #f0c040; color: #0f0f1a; }
        .btn-primary { background-color: #f0c040; border-color: #f0c040; color: #0f0f1a; font-weight: 600; }
        .btn-primary:hover { background-color: #d4a800; border-color: #d4a800; color: #0f0f1a; }
        .btn-outline-light:hover { color: #0f0f1a !important; }
        .text-gold { color: #f0c040; }
        .hero { background: linear-gradient(135deg, #16162a 0%, #0f0f1a 100%); padding: 60px 0; border-bottom: 2px solid #2e2e50; }
        .showing-card { background: #1c1c35; border: 1px solid #2e2e50; border-radius: 8px; padding: 1rem; margin-bottom: 0.75rem; }
        .showing-card:hover { border-color: #f0c040; }
        .page-link { background-color: #1c1c35 !important; border-color: #2e2e50 !important; color: #e8e8f0 !important; }
        .page-item.active .page-link { background-color: #f0c040 !important; border-color: #f0c040 !important; color: #0f0f1a !important; }
        footer { background-color: #16162a; border-top: 2px solid #2e2e50; }
        .form-control, .form-select { background-color: #16162a; border-color: #2e2e50; color: #e8e8f0; }
        .form-control:focus, .form-select:focus { background-color: #1c1c35; border-color: #f0c040; color: #e8e8f0; box-shadow: 0 0 0 0.2rem rgba(240,192,64,0.2); }
        .form-control::placeholder { color: #666; }
        label { color: #ccc; }
        .table { color: #e8e8f0; }
        .table-dark th { background-color: #16162a; }
        .alert-success { background-color: #1a3a1a; border-color: #2d6a2d; color: #6fcf6f; }
        .alert-danger { background-color: #3a1a1a; border-color: #6a2d2d; color: #cf6f6f; }
    </style>
    @stack('styles')
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('movies.index') }}">
            <i class="bi bi-camera-reels-fill"></i> CinemaTickets
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('movies.index') }}"><i class="bi bi-film"></i> Movies</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Admin</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main>
    @if (session('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @yield('content')
</main>

<footer class="py-4 mt-5">
    <div class="container text-center text-muted">
        <p class="mb-0">&copy; {{ date('Y') }} CinemaTickets &mdash; Laravel {{ app()->version() }} Demo</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
