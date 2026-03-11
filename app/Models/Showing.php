<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Showing extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'show_time',
        'hall',
        'available_seats',
    ];

    protected $casts = [
        'show_time' => 'datetime',
    ];

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function hasAvailableSeats(int $requested): bool
    {
        return $this->available_seats >= $requested;
    }
}
