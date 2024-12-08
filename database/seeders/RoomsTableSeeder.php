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
        Room::create(['name' => 'Red', 'type' => 'Regular', 'description' => 'Default Room', 'capacity' => 100]);
    }
}
