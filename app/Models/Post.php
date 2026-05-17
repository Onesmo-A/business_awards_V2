<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'type',
        'gallery_album_id', // Ongeza hapa
        'status',
        'featured_image',
        'media_gallery',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'media_gallery' => 'array',
    ];

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = ['featured_image_url', 'media_gallery_urls'];

    /**
     * Get the album that the post belongs to.
     */
    public function album(): BelongsTo
    {
        return $this->belongsTo(GalleryAlbum::class, 'gallery_album_id');
    }

    /**
     * Get the publicly accessible URL for the post's featured image.
     * Uses the StorageController to serve files (works on all servers without symlinks).
     * Returns null if no image is set.
     *
     * @return string|null
     */
    public function getFeaturedImageUrlAttribute(): ?string
    {
        if (empty($this->featured_image)) {
            return null;
        }
        return route('storage.file', ['path' => 'storage/' . $this->featured_image]);
    }

    /**
     * Get the publicly accessible URLs for all media gallery images.
     * Uses the StorageController to serve files (works on all servers without symlinks).
     * Returns empty array if no media is set.
     *
     * @return array
     */
    public function getMediaGalleryUrlsAttribute(): array
    {
        if (empty($this->media_gallery) || !is_array($this->media_gallery)) {
            return [];
        }
        
        return array_map(
            fn($path) => route('storage.file', ['path' => 'storage/' . $path]),
            $this->media_gallery
        );
    }
}
