<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    protected $fillable = [
        'route_id',
        'departure_time',
        'arrival_time',
        'vehicle_type',
        'seat_count',
        'price',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'departure_time' => 'datetime',
        'arrival_time' => 'datetime',
        'price' => 'decimal:0',
        'status' => 'boolean',
    ];

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    public function bookingClickLogs(): HasMany
    {
        return $this->hasMany(BookingClickLog::class);
    }
}
