<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use Sluggable;

    protected $fillable = [
        'post_category_id',
        'title',
        'slug',
        'thumbnail',
        'summary',
        'content',
        'meta_title',
        'meta_description',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'status' => 'boolean',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }
}
