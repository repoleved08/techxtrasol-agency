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
        Schema::create('case_studies', function (Blueprint $table) {
            $table->id();
            $table->string('industry')->nullable();        // e.g., "Healthcare Industry"
            $table->string('title');                         // e.g., "HealthConnect Platform"
            $table->text('description')->nullable();         // Detailed description
            // JSON columns for complex/nested data
            $table->json('highlights')->nullable();          // e.g., metrics like 200% Patient Engagement, etc.
            $table->json('approach')->nullable();            // e.g., details on your approach, bullet points, etc.
            $table->json('key_results')->nullable();         // e.g., key results as an array of strings
            $table->json('technologies')->nullable();        // e.g., list of technologies
            // Testimonial fields
            $table->string('testimonial_name')->nullable();
            $table->string('testimonial_title')->nullable();
            $table->text('testimonial_quote')->nullable();
            // SEO-friendly slug
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_studies');
    }
};
