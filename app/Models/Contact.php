<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'ads_mode',
        'replied_at',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
        'ads_mode' => 'boolean',
    ];
}
