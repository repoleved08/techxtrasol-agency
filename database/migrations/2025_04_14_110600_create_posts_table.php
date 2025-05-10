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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Main title for SEO and clickbait
            $table->string('slug')->unique(); // SEO-friendly URL
            $table->text('excerpt')->nullable(); // Short summary for meta description
            $table->longText('body'); // Full blog post content
            $table->string('meta_title')->nullable(); // SEO Title Tag
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('meta_description')->nullable(); // SEO Description Tag
            $table->string('meta_keywords')->nullable(); // SEO keywords (optional use)
            $table->string('featured_image')->nullable(); // Thumbnail / OpenGraph image
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Author
            $table->timestamp('published_at')->nullable(); // For scheduling posts
            $table->boolean('is_published')->default(false); // Draft or Published
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
