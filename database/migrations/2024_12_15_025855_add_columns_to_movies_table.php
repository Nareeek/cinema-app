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
        Schema::table('movies', function (Blueprint $table) {
            $table->string('rating')->nullable(); // Example: G, PG, R
            $table->string('genre')->nullable();  // Example: Action, Comedy
            $table->string('slug')->unique();     // For URL-friendly titles
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn(['rating', 'genre', 'slug']);
        });
    }
};
