<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Sluggable\SlugOptions;

class Resource extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'featured_image',
        'category_id',
        'user_id',
        'published_at',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_published'
    ];

    protected $appends = ['featured_image_url'];


    public function category()
    {
        return $this->belongsTo(ResourceCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'published_at' => 'datetime',
        'meta_keywords' => 'array'
    ];

    // Auto-generate excerpt if empty
    protected static function booted()
    {
        static::saving(function ($resource) {
            if (empty($resource->excerpt)) {
                $resource->excerpt = Str::limit(strip_tags($resource->body), 160);
            }
        });
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

   // In Resource model
public function getFeaturedImageUrlAttribute()
{
    // Always check if the field exists
    if (empty($this->featured_image)) {
        return asset('images/default-resource.jpg'); // Ensure this file exists
    }

    // Handle full URLs (e.g., from external sources)
    if (filter_var($this->featured_image, FILTER_VALIDATE_URL)) {
        return $this->featured_image;
    }

    // Handle local storage paths - NEW FIX
    $storagePath = 'storage/'.ltrim($this->featured_image, '/');

    // Verify file exists before returning
    return file_exists(public_path($storagePath))
        ? asset($storagePath)
        : asset('images/default-resource.jpg');
}
    // public function getRouteKeyName()
    // {
    //     return 'slug';
    // }
    // public function getExcerptAttribute($value)
    // {
    //     return $value ?: str()->limit(strip_tags($this->body), 150);
    // }
    // public function getMetaKeywordsAttribute($value)
    // {
    //     return $value ? json_decode($value) : [];
    // }
    // public function setMetaKeywordsAttribute($value)
    // {
    //     $this->attributes['meta_keywords'] = json_encode($value);
    // }
    // public function getPublishedAtAttribute($value)
    // {
    //     return $value ? \Carbon\Carbon::parse($value) : null;
    // }
    // public function setPublishedAtAttribute($value)
    // {
    //     $this->attributes['published_at'] = $value ? \Carbon\Carbon::parse($value) : null;
    // }
    // public function scopePublished($query)
    // {
    //     return $query->where('is_published', true)
    //         ->where('published_at', '<=', now());
    // }
}
