<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'author',
        'isbn', 'cover_image', 'file_path',
        'published_date', 'featured'
    ];

    protected $casts = [
        'featured' => 'boolean',
        'published_date' => 'date',
    ];

    public function incrementDownloadCount()
    {
        $this->download_count++;
        $this->save();
    }
}
