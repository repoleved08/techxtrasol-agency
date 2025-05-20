<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('books', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->string('slug')->unique();
      $table->text('description');
      $table->string('author');
      $table->string('isbn')->nullable();
      $table->string('cover_image')->nullable();
      $table->string('file_path'); // Where the PDF/book file is stored
      $table->integer('download_count')->default(0);
      $table->date('published_date')->nullable();
      $table->boolean('featured')->default(false);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('books');
  }
};
