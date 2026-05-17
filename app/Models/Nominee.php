<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Nominee extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'year', // BORESHO: Ongeza year
        'name',
        'bio',
        'image_path',
        'facebook_url',
        'instagram_url',
        'tiktok_url',
        'votes_count' // BORESHO: Ruhusu votes_count ijazwe wakati wa migration
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Mshiriki anaweza kuwa na kura nyingi.
     */
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

// ... ndani ya class ya Nominee
protected $appends = ['image_url'];
    /**
     * Get the publicly accessible URL for the nominee's image.
     * Uses the StorageController to serve files (works on all servers without symlinks).
     * Returns null if no image is set.
     *
     * @return string|null
     */
    public function getImageUrlAttribute(): ?string
    {
        // return Storage::url($this->image_path);
    if (empty($this->image_path)) {
        return null;
    }

    // Remove 'public/' prefix if it exists (for legacy data)
    $cleanPath = str_replace('public/', '', $this->image_path);

    // Badilisha ili itumie route sahihi
    return route('storage.file', ['path' => 'storage/' . $cleanPath]);
}

}