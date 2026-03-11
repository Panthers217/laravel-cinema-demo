<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'genre',
        'duration_minutes',
        'release_date',
        'ticket_price',
        'poster_url',
        'total_seats',
        'is_active',
    ];

    protected $casts = [
        'release_date' => 'date',
        'ticket_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function showings(): HasMany
    {
        return $this->hasMany(Showing::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
