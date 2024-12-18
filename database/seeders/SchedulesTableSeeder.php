<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;
use App\Models\Room;
use App\Models\Movie;
use Carbon\Carbon;

class SchedulesTableSeeder extends Seeder
{
    public function run()
    {
        // Fetch all rooms and movies
        $rooms = Room::all();
        $movies = Movie::all();

        // Define parameters for schedule creation
        $totalSchedulesPerRoom = 8; // More schedules per room
        $scheduleStartTime = Carbon::today()->addHours(10); // Start at 10:00 AM
        $intervalMinutes = 120; // 2-hour intervals

        foreach ($rooms as $room) {
            $currentScheduleTime = $scheduleStartTime;

            for ($i = 1; $i <= $totalSchedulesPerRoom; $i++) {
                $movie = $movies->random(); // Pick a random movie

                // Ensure the movie isn't already scheduled at the same time globally
                if (Schedule::where('movie_id', $movie->id)
                    ->where('schedule_time', $currentScheduleTime)
                    ->exists()) {
                    $currentScheduleTime->addMinutes($intervalMinutes); // Skip to the next time slot
                    continue;
                }

                // Ensure no overlapping schedules for the same room
                if (Schedule::where('room_id', $room->id)
                    ->where('schedule_time', $currentScheduleTime)
                    ->exists()) {
                    $currentScheduleTime->addMinutes($intervalMinutes); // Skip to the next time slot
                    continue;
                }

                // Create the schedule
                Schedule::create([
                    'room_id' => $room->id,
                    'movie_id' => $movie->id,
                    'schedule_time' => $currentScheduleTime->toDateTimeString(),
                    'status' => 'Active',
                ]);

                // Increment the schedule time
                $currentScheduleTime->addMinutes($intervalMinutes);
            }
        }
    }
}
