<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'reference',
        'route_id',
        'schedule_id',
        'travel_date',
        'return_schedule_id',
        'return_travel_date',
        'passenger_count',
        'passenger_name',
        'passenger_email',
        'passenger_phone',
        'pickup_point',
        'dropoff_point',
        'seat_preference',
        'notes',
        'outbound_fare',
        'return_fare',
        'total_amount',
        'currency',
        'status',
        'locale',
    ];

    protected $casts = [
        'travel_date' => 'date',
        'return_travel_date' => 'date',
        'outbound_fare' => 'integer',
        'return_fare' => 'integer',
        'total_amount' => 'integer',
        'passenger_count' => 'integer',
    ];

    public function getRouteKeyName(): string
    {
        return 'reference';
    }

    public function scopeReserving(Builder $query): Builder
    {
        return $query->whereIn('status', ['pending', 'confirmed']);
    }

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function returnSchedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class, 'return_schedule_id');
    }
}
