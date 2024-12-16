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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('room_id')->constrained()->cascadeOnDelete(); // Foreign key to Rooms
            $table->foreignId('movie_id')->constrained()->cascadeOnDelete(); // Foreign key to Movies
            $table->dateTime('schedule_time'); // Showtime
            $table->decimal('price', 8, 2); // Ticket price
            $table->string('status')->default('Active'); // Active/Inactive status
            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // Soft deletion timestamp
        
            // Unique constraint for room schedule
            $table->unique(['room_id', 'schedule_time'], 'unique_room_schedule');
        
            // Unique constraint for movie schedule across rooms
            $table->unique(['movie_id', 'schedule_time'], 'unique_movie_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
