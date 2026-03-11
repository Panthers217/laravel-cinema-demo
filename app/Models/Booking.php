<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'showing_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'seats_booked',
        'total_price',
        'booking_reference',
        'status',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (Booking $booking) {
            $booking->booking_reference = 'CIN-' . strtoupper(Str::random(8));
        });
    }

    public function showing(): BelongsTo
    {
        return $this->belongsTo(Showing::class);
    }
}
