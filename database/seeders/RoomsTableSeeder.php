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
            'capacity' => 100,
        ]);

        Room::create([
            'name' => 'VIP Room',
            'type' => 'VIP',
            'description' => 'Luxury seating with personalized service',
            'capacity' => 50,
        ]);
    }
}
