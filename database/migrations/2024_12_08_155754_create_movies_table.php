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
        Schema::create('movies', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('title'); // Movie title
            $table->text('description')->nullable(); // Movie description
            $table->string('poster_url')->nullable()->default(null); // URL for poster image
            $table->string('trailer_url')->nullable(); // Optional trailer link
            $table->integer('duration'); // Duration in minutes
            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // Soft deletion timestamp
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
