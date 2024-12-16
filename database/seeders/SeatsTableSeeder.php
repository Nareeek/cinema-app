<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeatsTableSeeder extends Seeder
{
    public function run()
    {
        $schedules = DB::table('schedules')->pluck('id');
        $seats = [];

        foreach ($schedules as $scheduleId) {
            $seatCount = rand(20, 100); // Random number of seats
            for ($i = 1; $i <= $seatCount; $i++) {
                $seats[] = [
                    'schedule_id' => $scheduleId,
                    'seat_number' => $i,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('seats')->insert($seats);
    }
}
