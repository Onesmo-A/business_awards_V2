<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SeasonAward extends Model
{
    protected $fillable = [
        'year',
        'theme',
        'description',
        'event_date',
        'cover_image_path',
        'can_show_winners',
    ];

    protected $casts = [
        'event_date' => 'date',
        'can_show_winners' => 'boolean',
    ];

    // Hii inahakikisha 'cover_image_url' inatumwa pamoja na data ya msimu
    protected $appends = ['cover_image_url'];

    // Accessor ya kutengeneza URL kamili ya picha
    public function getCoverImageUrlAttribute()
    {
        // Tumia route ya 'storage.file' ili kupitia StorageController
        // Hii inahakikisha picha zinapatikana hata kwenye shared hosting ambapo symlinks hazifanyi kazi
        return $this->cover_image_path 
            ? route('storage.file', ['path' => 'storage/' . $this->cover_image_path]) 
            : null;
    }

    /**
     * Relationship: SeasonAward ina washindi wengi
     * Inaunganisha kupitia field ya 'year'
     */
    public function winners()
    {
        return $this->hasMany(Winner::class, 'year', 'year');
    }
}