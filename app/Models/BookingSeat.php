<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingSeat extends Model
{
    protected $fillable = [
        'booking_id',
        'trip_code',
        'travel_date',
        'seat',
    ];

    protected $casts = [
        'travel_date' => 'date',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
