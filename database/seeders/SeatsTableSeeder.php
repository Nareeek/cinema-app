<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Seat;
use Illuminate\Database\Seeder;

class SeatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Example: Add seats for Room 1 (Red Room)
        for ($row = 1; $row <= 10; $row++) {
            for ($seat = 1; $seat <= 10; $seat++) {
                Seat::create([
                    'room_id' => 1, // Assuming Room 1 (Red Room)
                    'row_number' => $row,
                    'seat_number' => $seat,
                    'price' => 15.00, // Example price
                ]);
            }
        }

        // Example: Add seats for Room 2 (Blue Room)
        for ($row = 1; $row <= 5; $row++) {
            for ($seat = 1; $seat <= 8; $seat++) {
                Seat::create([
                    'room_id' => 2,
                    'row_number' => $row,
                    'seat_number' => $seat,
                    'price' => 20.00, // Example price
                ]);
            }
        }

        // Example: Add seats for Room 3 (Green Room)
        for ($row = 1; $row <= 5; $row++) {
            for ($seat = 1; $seat <= 8; $seat++) {
                Seat::create([
                    'room_id' => 3,
                    'row_number' => $row,
                    'seat_number' => $seat,
                    'price' => 15.00, // Example price
                ]);
            }
        }

        // Example: Add seats for Room 4 (VIP Room)
        for ($row = 1; $row <= 5; $row++) {
            for ($seat = 1; $seat <= 8; $seat++) {
                Seat::create([
                    'room_id' => 4, // Assuming Room 4 (VIP Room)
                    'row_number' => $row,
                    'seat_number' => $seat,
                    'price' => 54.00, // Example price
                ]);
            }
        }
    }
}
