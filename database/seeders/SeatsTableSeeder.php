<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;
use App\Models\Seat;

class SeatsTableSeeder extends Seeder
{
    public function run()
    {
        // Define rows and seats per row
        $rowsPerSchedule = 5; // Adjust as needed
        $seatsPerRow = 10; // Adjust as needed
        $prices = range(10, 50); // Possible seat prices

        // Fetch all schedules
        $schedules = Schedule::all();

        foreach ($schedules as $schedule) {
            for ($row = 1; $row <= $rowsPerSchedule; $row++) {
                for ($seatNumber = 1; $seatNumber <= $seatsPerRow; $seatNumber++) {
                    // Assign a random price for each seat
                    $price = $prices[array_rand($prices)];

                    Seat::create([
                        'schedule_id' => $schedule->id,
                        'seat_number' => $seatNumber, // Example: 1-6 Row 1
                        'row_number' => $row, // Example: 1-6 Seat 6
                        'price' => $price,
                        'is_booked' => 0, // Default status
                    ]);
                }
            }
        }
    }
}
