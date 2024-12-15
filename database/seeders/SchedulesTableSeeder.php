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
        $rooms = Room::all();
        $movies = Movie::all();
        $scheduleStartTime = Carbon::today()->addHours(10); // Start at 10:00 AM
        $intervalMinutes = 180; // 3-hour intervals
    
        foreach ($rooms as $room) {
            $currentScheduleTime = $scheduleStartTime;
    
            foreach ($movies->take(20) as $movie) { // Use up to 20 movies per room
                // Ensure unique schedule_time for the room
                if (Schedule::where('room_id', $room->id)->where('schedule_time', $currentScheduleTime)->exists()) {
                    $currentScheduleTime->addMinutes($intervalMinutes); // Skip to the next available time slot
                    continue;
                }
    
                Schedule::create([
                    'room_id' => $room->id,
                    'movie_id' => $movie->id,
                    'schedule_time' => $currentScheduleTime->toDateTimeString(),
                    'price' => rand(10, 30), // Random price between 10 and 30
                    'status' => 'Active',
                ]);
    
                $currentScheduleTime->addMinutes($intervalMinutes); // Move to the next time slot
            }
        }
    }
}
