<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VoteAttemptLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'reason',
        'nominee_id',
        'category_id',
        'vote_id',
        'ip_address',
        'user_agent',
        'fingerprint_js_hash',
        'browser_token_hash',
        'screen_resolution',
        'timezone',
        'language',
        'request_id',
        'message',
        'context',
    ];

    protected $casts = [
        'context' => 'array',
    ];

    public function nominee(): BelongsTo
    {
        return $this->belongsTo(Nominee::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function vote(): BelongsTo
    {
        return $this->belongsTo(Vote::class);
    }
}
