<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'image',
        'button_text',
        'button_url',
        'position',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Whether the banner has a valid stored image.
     * Guards against corrupted values like '0' or empty strings.
     */
    public function hasImage(): bool
    {
        $image = $this->image;

        return is_string($image) && trim($image) !== '' && $image !== '0';
    }

    /**
     * Public URL for the banner image (served from the "public" disk),
     * or null when no valid image is stored.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->hasImage()
            ? Storage::disk('public')->url($this->image)
            : null;
    }
}
