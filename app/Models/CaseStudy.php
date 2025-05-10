<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CaseStudy extends Model
{
    use HasFactory;

    protected $fillable = [
        'industry',
        'title',
        'description',
        'highlights',
        'approach',
        'key_results',
        'technologies',
        'testimonial_name',
        'testimonial_title',
        'testimonial_quote',
        // added fields
        'project_type',
        'short_description',
        'client_name',
        'project_date',
        'key_metrics',
        'featured_image',
        'gallery_images',
    ];

    protected $casts = [
        'highlights'   => 'array',
        'approach'     => 'array',
        'key_results'  => 'array',
        'technologies' => 'array',
        'key_metrics' => 'array',
        'gallery_images' => 'array',
        'project_date' => 'date'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($caseStudy) {
            $caseStudy->generateSlug();
        });

        static::updating(function ($caseStudy) {
            if ($caseStudy->isDirty('title')) {
                $caseStudy->generateSlug();
            }
        });
    }

    protected function generateSlug()
    {
        $baseSlug = Str::slug($this->title);
        $slug = $baseSlug;
        $counter = 1;

        // Check for existing slugs
        while (
            CaseStudy::where('slug', $slug)
            ->where('id', '!=', $this->id ?? null)
            ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        $this->slug = $slug;
    }

    public function getImageUrlAttribute()
    {
        if (!$this->featured_image) {
            return asset('images/default-case-study.jpg');
        }
        return Storage::url($this->featured_image);
    }

    public function getGalleryUrlsAttribute()
    {
        return collect($this->gallery_images)->map(function ($image) {
            return Storage::url($image);
        });
    }
}
