<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

// Public movie listing & detail
Route::get('/', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

// Ticket booking
Route::get('/showings/{showing}/book', [BookingController::class, 'create'])->name('bookings.create');
Route::post('/showings/{showing}/book', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/bookings/{booking}/confirmation', [BookingController::class, 'confirmation'])->name('bookings.confirmation');

// Admin panel (no auth for demo purposes — add Laravel Breeze/Sanctum for production)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Movies CRUD
    Route::get('/movies', [AdminController::class, 'moviesIndex'])->name('movies.index');
    Route::get('/movies/create', [AdminController::class, 'moviesCreate'])->name('movies.create');
    Route::post('/movies', [AdminController::class, 'moviesStore'])->name('movies.store');
    Route::get('/movies/{movie}/edit', [AdminController::class, 'moviesEdit'])->name('movies.edit');
    Route::put('/movies/{movie}', [AdminController::class, 'moviesUpdate'])->name('movies.update');
    Route::delete('/movies/{movie}', [AdminController::class, 'moviesDestroy'])->name('movies.destroy');

    // Showings
    Route::get('/movies/{movie}/showings/create', [AdminController::class, 'showingsCreate'])->name('showings.create');
    Route::post('/movies/{movie}/showings', [AdminController::class, 'showingsStore'])->name('showings.store');

    // Bookings list
    Route::get('/bookings', [AdminController::class, 'bookingsIndex'])->name('bookings.index');
});
