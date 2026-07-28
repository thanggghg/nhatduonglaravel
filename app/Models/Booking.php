<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    protected $fillable = [
        'reference',
        'route_id',
        'schedule_id',
        'trip_code',
        'public_booking_order_id',
        'public_booking_status',
        'public_booking_ticket_codes',
        'public_booking_codes',
        'public_booking_idempotency_key',
        'departure_at',
        'arrival_at',
        'vehicle_type',
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
        'selected_seats',
        'notes',
        'outbound_fare',
        'return_fare',
        'total_amount',
        'currency',
        'status',
        'payment_code',
        'payment_status',
        'payment_provider',
        'payment_transaction_id',
        'payment_reference',
        'payment_payload',
        'paid_at',
        'locale',
    ];

    protected $casts = [
        'travel_date' => 'date',
        'return_travel_date' => 'date',
        'departure_at' => 'datetime',
        'arrival_at' => 'datetime',
        'outbound_fare' => 'integer',
        'return_fare' => 'integer',
        'total_amount' => 'integer',
        'passenger_count' => 'integer',
        'selected_seats' => 'array',
        'public_booking_ticket_codes' => 'array',
        'public_booking_codes' => 'array',
        'payment_payload' => 'array',
        'paid_at' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'reference';
    }

    public function scopeReserving(Builder $query): Builder
    {
        return $query->whereIn('status', ['external_pending', 'pending', 'confirmed']);
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

    public function seatReservations(): HasMany
    {
        return $this->hasMany(BookingSeat::class);
    }
}
