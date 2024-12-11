<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Booking;
use App\Models\Seat;
use Illuminate\Database\Seeder;

class BookingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch valid seat IDs for Schedule 1
        $seat = Seat::where('room_id', 1)->first();

        Booking::create([
            'schedule_id' => 1,
            'seat_id' => $seat->id, // Ensure valid seat_id
            'user_email' => 'user@example.com',
            'user_phone' => '123-456-7890',
            'status' => 'Confirmed',
        ]);

        // Fetch another seat ID for Schedule 2
        $seat = Seat::where('room_id', 2)->first();

        Booking::create([
            'schedule_id' => 2,
            'seat_id' => $seat->id, // Ensure valid seat_id
            'user_email' => 'anotheruser663@example.com',
            'user_phone' => '687-654-3210',
            'status' => 'Pending',
        ]);

        // Fetch another seat ID for Schedule 1
        $seat = Seat::where('room_id', 2)->first();

        Booking::create([
            'schedule_id' => 1,
            'seat_id' => $seat->id, // Ensure valid seat_id
            'user_email' => 'anotheruser664@example.com',
            'user_phone' => '967-654-3210',
            'status' => 'Confirmed',
        ]);

        // Fetch another seat ID for Schedule 3
        $seat = Seat::where('room_id', 3)->first();

        Booking::create([
            'schedule_id' => 3,
            'seat_id' => $seat->id, // Ensure valid seat_id
            'user_email' => 'anotheruser665@example.com',
            'user_phone' => '887-654-3210',
            'status' => 'Pending',
        ]);

        // Fetch another seat ID for Schedule 4
        $seat = Seat::where('room_id', 4)->first();

        Booking::create([
            'schedule_id' => 4,
            'seat_id' => $seat->id, // Ensure valid seat_id
            'user_email' => 'anotheruser666@example.com',
            'user_phone' => '987-654-3210',
            'status' => 'Confirmed',
        ]);
    }
}
