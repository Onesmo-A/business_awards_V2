<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VoterArchive extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'original_vote_id',
        'season_year',
        'nominee_id',
        'category_id',
        'nominee_name',
        'category_name',
        'ip_address',
        'user_agent',
        'fingerprint',
        'fingerprint_js',
        'fingerprint_js_hash',
        'screen_resolution',
        'timezone',
        'language',
        'multi_factor_hash',
        'voted_at',
        'vote_created_at',
        'vote_updated_at',
        'archived_at',
    ];

    public function nominee(): BelongsTo
    {
        return $this->belongsTo(Nominee::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
