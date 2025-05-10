<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'user_id',
        'token',
        'verified_at',
        'is_active',
        'preferences'
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'preferences' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeVerified($query)
    {
        return $query->whereNotNull('verified_at');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
