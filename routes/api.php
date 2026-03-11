<?php

use App\Http\Controllers\Api\MovieApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public movie API
Route::prefix('movies')->name('api.movies.')->group(function () {
    Route::get('/', [MovieApiController::class, 'index'])->name('index');
    Route::get('/genres', [MovieApiController::class, 'genres'])->name('genres');
    Route::get('/{movie}', [MovieApiController::class, 'show'])->name('show');
});
