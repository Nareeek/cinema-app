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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('schedule_id')->constrained()->cascadeOnDelete(); // Foreign key to Schedules
            $table->foreignId('seat_id')->constrained()->cascadeOnDelete(); // Foreign key to Seats
            $table->string('user_email'); // User's email
            $table->string('user_phone'); // User's phone
            $table->string('status')->default('Pending'); // Booking status: Pending, Confirmed
            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // Soft deletion timestamp
        
            // Add unique constraint
            $table->unique(['schedule_id', 'seat_id'], 'unique_schedule_seat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
