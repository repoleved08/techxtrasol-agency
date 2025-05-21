<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
  protected $fillable = [
    'title',
    'slug',
    'description',
    'author',
    'isbn',
    'cover_image',
    'file_path',
    'published_date',
    'featured'
  ];

  protected $casts = [
    'featured' => 'boolean',
    'published_date' => 'date',
  ];

  protected static function booted()
  {
    static::saving(function (Book $book) {
      if (empty($book->slug) && !empty($book->title)) {
        $book->slug = Str::slug($book->title);
      }
    });
  }

  public function incrementDownloadCount()
  {
    $this->download_count++;
    $this->save();
  }
}
