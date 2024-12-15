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
            ['name' => 'Romantic Comedy', 'capacity' => 140, 'type' => 'romantic_comedy', 'image_url' => 'romantic_comedy.jpg'],
            ['name' => 'Animations', 'capacity' => 30, 'type' => 'animations', 'image_url' => 'animations.jpg'],
            ['name' => 'Musicals', 'capacity' => 200, 'type' => 'musicals', 'image_url' => 'musicals.jpg'],
            ['name' => 'Comedy', 'capacity' => 85, 'type' => 'comedy', 'image_url' => 'comedy.jpg'],
            ['name' => 'History', 'capacity' => 10, 'type' => 'history', 'image_url' => 'history.jpg'],
            ['name' => 'Documentary', 'capacity' => 140, 'type' => 'documentary', 'image_url' => 'documentary.jpg'],
            ['name' => 'Western', 'capacity' => 90, 'type' => 'Uzbek', 'image_url' => 'western.jpg'],
            ['name' => 'Crime', 'capacity' => 120, 'type' => 'crime', 'image_url' => 'crime.jpg'],
            ['name' => 'Mystery', 'capacity' => 90, 'type' => 'mystery', 'image_url' => 'mystery.jpg'],
            ['name' => 'Sci Fi', 'capacity' => 160, 'type' => 'sci_fi', 'image_url' => 'sci_fi.jpg'],
            ['name' => 'Horror', 'capacity' => 110, 'type' => 'horror', 'image_url' => 'horror.jpg'],
            ['name' => 'Thriller', 'capacity' => 140, 'type' => 'thriller', 'image_url' => 'thriller.jpg'],
            ['name' => 'Noir', 'capacity' => 140, 'type' => 'noir', 'image_url' => 'noir.jpg'],
            ['name' => 'Magic Realizm', 'capacity' => 140, 'type' => 'VIP', 'image_url' => 'magic_realizm.jpg'],
        ];

        // Insert data using Eloquent
        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
