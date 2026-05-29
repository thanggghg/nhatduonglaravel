<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Cviebrock\EloquentSluggable\Sluggable;

class Route extends Model
{
    use Sluggable;

    protected $fillable = [
        'name',
        'slug',
        'from_location',
        'to_location',
        'distance',
        'estimated_time',
        'price_from',
        'image',
        'description',
        'booking_url',
        'status',
    ];

    protected $casts = [
        'price_from' => 'decimal:0',
        'status' => 'boolean',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function pickupPoints(): HasMany
    {
        return $this->hasMany(PickupPoint::class);
    }

    public function dropoffPoints(): HasMany
    {
        return $this->hasMany(DropoffPoint::class);
    }

    public function bookingClickLogs(): HasMany
    {
        return $this->hasMany(BookingClickLog::class);
    }
}
