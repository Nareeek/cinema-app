<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room; // Import the Room model

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Room::create([
            'name' => 'Red Room',
            'type' => 'Regular',
            'description' => 'Main hall with large screen',
            'image_url' => 'room1.jpg', // Relative path from public/
            'capacity' => 100,
        ]);

        Room::create([
            'name' => 'Blue Room',
            'type' => 'For kids',
            'description' => 'Hall for kids and family atmosphere',
            'image_url' => 'room2.jpg', // Relative path from public/
            'capacity' => 150,
        ]);

        Room::create([
            'name' => 'Green Room',
            'type' => 'Not translated',
            'description' => 'The hall, where all films are not translated (in english).',
            'image_url' => 'room3.jpg', // Relative path from public/
            'capacity' => 50,
        ]);

        Room::create([
            'name' => 'VIP Room',
            'type' => 'VIP',
            'description' => 'Luxury seating with personalized service',
            'image_url' => 'room4.jpg', // Relative path from public/
            'capacity' => 80,
        ]);
    }
}
