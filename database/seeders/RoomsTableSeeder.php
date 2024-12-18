<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomsTableSeeder extends Seeder
{
    public function run()
    {
        // Define room data
        $rooms = [
            ['name' => 'Musicals', 'capacity' => 200, 'type' => 'musicals', 'image_url' => 'musicals.jpg'],
            ['name' => 'Comedy', 'capacity' => 85, 'type' => 'comedy', 'image_url' => 'comedy.jpg'],
            ['name' => 'History', 'capacity' => 10, 'type' => 'history', 'image_url' => 'history.jpg'],
            ['name' => 'Western', 'capacity' => 90, 'type' => 'Uzbek', 'image_url' => 'western.jpg'],
        ];

        // Insert data using Eloquent
        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
