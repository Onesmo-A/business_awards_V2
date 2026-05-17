<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'event_date',
        'event_time',
        'location_name',
        'google_maps_embed_url',
        'is_active',
        'dress_code',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}