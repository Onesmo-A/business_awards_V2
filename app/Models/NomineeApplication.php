<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Storage;

class NomineeApplication extends Model
{
    use HasFactory;
    const STATUS_PENDING_PAYMENT = 'pending_payment';
    const STATUS_PAYMENT_FAILED = 'payment_failed';
    const STATUS_PENDING_REVIEW = 'pending_review';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
  

    protected $fillable = [
        'user_id', 
        'category_id', 
        'applicant_name', 
        'business_name', // New
        'age',           // New
        'nationality',   // New
        'country_of_residence', // New
        'city',          // New
        'applicant_phone',
        'applicant_email', 
        'bio', 
        'facebook_url',
        'instagram_url',
        'tiktok_url',
        'photo_path', 
        'status',
        'reviewed_by',
        'reviewed_at',
        'rejection_reason',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    protected $appends = ['photo_url'];

    /**
     * Get the publicly accessible URL for the applicant's photo.
     * Uses the StorageController to serve files (works on all servers without symlinks).
     *
     * @return string|null
     */
    public function getPhotoUrlAttribute(): ?string
    {
        if (empty($this->photo_path)) {
            return null;
        }
        return route('storage.file', ['path' => 'storage/' . $this->photo_path]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function transaction(): MorphOne
    {
        return $this->morphOne(Transaction::class, 'payable');
    }

    /**
     * Pata mtumiaji (admin) aliyefanya mapitio ya ombi hili.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
    
}
