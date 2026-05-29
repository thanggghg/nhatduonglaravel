<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PickupPoint extends Model
{
    protected $fillable = [
        'route_id',
        'name',
        'address',
        'time',
        'sort_order',
    ];

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }
}
