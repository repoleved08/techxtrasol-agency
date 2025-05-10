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
        Schema::table('case_studies', function (Blueprint $table) {
            // Add these new fields
            $table->string('project_type')->default('web'); // ['web', 'mobile', 'ai', 'ecommerce', 'finance']
            $table->text('short_description')->nullable();
            $table->string('client_name')->nullable();
            $table->date('project_date')->nullable();
            $table->json('key_metrics')->nullable(); // For stats like "75% Faster Reporting"
            $table->string('featured_image')->nullable();
            $table->json('gallery_images')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('case_studies', function (Blueprint $table) {
            // Drop the fields if they exist
            $table->dropColumn('project_type');
            $table->dropColumn('short_description');
            $table->dropColumn('client_name');
            $table->dropColumn('project_date');
            $table->dropColumn('key_metrics');
            $table->dropColumn('featured_image');
            $table->dropColumn('gallery_images');
        });
        // If you have any foreign keys or indexes, drop them here
    }
};
