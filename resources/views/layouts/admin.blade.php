<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — @yield('title', 'Dashboard') | CinemaTickets</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #0e0e1c; color: #e8e8f0; }
        .sidebar { background-color: #16162a; min-height: 100vh; width: 240px; flex-shrink: 0; border-right: 2px solid #2e2e50; }
        .sidebar .brand { color: #f0c040; font-weight: 700; font-size: 1.25rem; padding: 1.25rem 1rem; border-bottom: 1px solid #2e2e50; }
        .sidebar .nav-link { color: #ccc; padding: 0.65rem 1rem; border-radius: 6px; margin: 2px 8px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: #f0c040; background-color: #1c1c35; }
        .sidebar .nav-link i { width: 22px; }
        .main-content { flex: 1; padding: 2rem; min-width: 0; }
        .card { background-color: #1c1c35; border: 1px solid #2e2e50; color: #e8e8f0; }
        .stat-card { border-left: 4px solid #f0c040; }
        .table { color: #e8e8f0; }
        .table thead th { background-color: #16162a; border-color: #2e2e50; }
        .table td, .table th { border-color: #2e2e50; }
        .table-hover tbody tr:hover { background-color: rgba(240,192,64,0.05); }
        .btn-primary { background-color: #f0c040; border-color: #f0c040; color: #0f0f1a; font-weight: 600; }
        .btn-primary:hover { background-color: #d4a800; border-color: #d4a800; color: #0f0f1a; }
        .text-gold { color: #f0c040; }
        .form-control, .form-select, textarea { background-color: #16162a !important; border-color: #2e2e50 !important; color: #e8e8f0 !important; }
        .form-control:focus, .form-select:focus, textarea:focus { border-color: #f0c040 !important; box-shadow: 0 0 0 0.2rem rgba(240,192,64,0.2) !important; }
        .form-control::placeholder { color: #555 !important; }
        label { color: #bbb; }
        .badge-genre { background-color: #f0c040; color: #0f0f1a; }
        .alert-success { background-color: #1a3a1a; border-color: #2d6a2d; color: #6fcf6f; }
        .alert-danger { background-color: #3a1a1a; border-color: #6a2d2d; color: #cf6f6f; }
        .page-link { background-color: #1c1c35 !important; border-color: #2e2e50 !important; color: #e8e8f0 !important; }
        .page-item.active .page-link { background-color: #f0c040 !important; border-color: #f0c040 !important; color: #0f0f1a !important; }
    </style>
</head>
<body>
<div class="d-flex">
    {{-- Sidebar --}}
    <div class="sidebar d-flex flex-column">
        <div class="brand">
            <i class="bi bi-camera-reels-fill me-2"></i>CinemaTickets
        </div>
        <div class="small text-muted px-3 pt-2 pb-1" style="font-size: 0.7rem; letter-spacing: 1px; text-transform: uppercase;">Admin Panel</div>
        <nav class="nav flex-column pt-1">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
               href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('admin.movies.*') ? 'active' : '' }}"
               href="{{ route('admin.movies.index') }}">
                <i class="bi bi-film"></i> Movies
            </a>
            <a class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}"
               href="{{ route('admin.bookings.index') }}">
                <i class="bi bi-ticket-perforated"></i> Bookings
            </a>
            <hr style="border-color: #2e2e50; margin: 0.5rem 1rem;">
            <a class="nav-link" href="{{ route('movies.index') }}" target="_blank">
                <i class="bi bi-box-arrow-up-right"></i> View Site
            </a>
            <form action="{{ route('admin.logout') }}" method="POST" class="mt-auto mb-3 px-2">
                @csrf
                <button type="submit" class="nav-link btn btn-link w-100 text-start" style="text-decoration: none;">
                    <i class="bi bi-box-arrow-left"></i> Logout
                </button>
            </form>
        </nav>
    </div>

    {{-- Main Content --}}
    <div class="main-content">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
