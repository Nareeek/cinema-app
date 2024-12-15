<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\Schedule;
use App\Models\Movie;
use App\Models\Room;

class SchedulesTableSeeder extends Seeder
{
    public function run()
    {
        $movies = Movie::all();
        $rooms = Room::all();

        if ($movies->isEmpty() || $rooms->isEmpty()) {
            $this->command->info('No movies or rooms found. Please seed movies and rooms first.');
            return;
        }

        // Track unique schedule times for each movie and room
        $movieScheduleTimes = [];
        $roomScheduleTimes = [];

        foreach ($movies as $movie) {
            foreach ($rooms as $room) {
                // Initialize tracking arrays for movie and room if not already set
                if (!isset($movieScheduleTimes[$movie->id])) {
                    $movieScheduleTimes[$movie->id] = [];
                }
                if (!isset($roomScheduleTimes[$room->id])) {
                    $roomScheduleTimes[$room->id] = [];
                }

                // Generate 3 schedules per movie-room combination
                for ($i = 0; $i < 3; $i++) {
                    do {
                        // Generate a random schedule time
                        $scheduleTime = Carbon::now()
                            ->addDays(rand(1, 7))
                            ->addHours(rand(0, 23))
                            ->format('Y-m-d H:i:s');
                    } while (
                        in_array($scheduleTime, $movieScheduleTimes[$movie->id]) || // Ensure unique for movie
                        in_array($scheduleTime, $roomScheduleTimes[$room->id])    // Ensure unique for room
                    );

                    // Store the generated schedule time for both movie and room
                    $movieScheduleTimes[$movie->id][] = $scheduleTime;
                    $roomScheduleTimes[$room->id][] = $scheduleTime;

                    // Create the schedule
                    Schedule::create([
                        'movie_id' => $movie->id,
                        'room_id' => $room->id,
                        'schedule_time' => $scheduleTime,
                        'price' => rand(10, 20), // Random price between $10 and $20
                    ]);
                }
            }
        }
    }
}
