<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchedulesTableSeeder extends Seeder
{
    public function run()
    {
        $schedules = [
            ['movie_id' => 1, 'room_id' => 1, 'schedule_time' => '2024-12-16 00:00:00', 'price' => 36, 'status' => 'Active'],
            ['movie_id' => 2, 'room_id' => 1, 'schedule_time' => '2024-12-16 02:00:00', 'price' => 33, 'status' => 'Active'],
            // Ensure all `movie_id` + `schedule_time` combinations are unique
        ];

        $existingSchedules = DB::table('schedules')
            ->select('movie_id', 'schedule_time')
            ->get()
            ->toArray();


        foreach ($schedules as $schedule) {
            if (in_array(['movie_id' => $schedule['movie_id'], 'schedule_time' => $schedule['schedule_time']], $existingSchedules)) {
                dd('Duplicate found', $schedule);
            }
        }
    }
}


