<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'meta_title',
        'category_id',
        'meta_description',
        'meta_keywords',
        'featured_image',
        'user_id',
        'published_at',
        'is_published'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    protected static function booted()
    {
        static::saving(function (Post $post) {
            if (empty($post->slug) && !empty($post->title)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }
}
