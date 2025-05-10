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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('USER')->after('email'); // Adding role column with default value 'user'
            // You can also add other roles like 'admin', 'editor', etc. as needed
           //$table->enum('role', ['admin', 'editor', 'user'])->default('user')->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role'); // Dropping the role column
        });
    }
};
