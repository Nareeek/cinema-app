<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Schedule;
use Illuminate\Database\Seeder;

class SchedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schedule::create([
            'room_id' => 1, // Red Room
            'movie_id' => 1, // Avatar 2
            'schedule_time' => now()->addDays(1)->setTime(18, 0), // Tomorrow at 6 PM
            'price' => 12.99,
            'status' => 'Active',
        ]);

        Schedule::create([
            'room_id' => 2, // VIP Room
            'movie_id' => 2, // The Batman
            'schedule_time' => now()->addDays(1)->setTime(20, 0), // Tomorrow at 8 PM
            'price' => 24.99,
            'status' => 'Active',
        ]);
    }
}
