<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Schedule;
use Illuminate\Database\Seeder;

class SchedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {        
        Schedule::create([
            'room_id' => 1,
            'movie_id' => 2,
            'show_date' => now()->addDays(1)->toDateString(),
            'schedule_time' => now()->addDays(1)->setTime(12, 0),
            'price' => 15.50,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 1,
            'movie_id' => 3,
            'show_date' => now()->addDays(1)->toDateString(),
            'schedule_time' => now()->addDays(1)->setTime(14, 30),
            'price' => 18.75,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 1,
            'movie_id' => 4,
            'show_date' => now()->addDays(1)->toDateString(),
            'schedule_time' => now()->addDays(1)->setTime(17, 0),
            'price' => 15.00,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 1,
            'movie_id' => 5,
            'show_date' => now()->addDays(1)->toDateString(),
            'schedule_time' => now()->addDays(1)->setTime(20, 0),
            'price' => 12.99,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 2,
            'movie_id' => 6,
            'show_date' => now()->addDays(1)->toDateString(),
            'schedule_time' => now()->addDays(1)->setTime(10, 0),
            'price' => 14.20,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 2,
            'movie_id' => 7,
            'show_date' => now()->addDays(1)->toDateString(),
            'schedule_time' => now()->addDays(1)->setTime(13, 0),
            'price' => 16.99,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 2,
            'movie_id' => 8,
            'show_date' => now()->addDays(1)->toDateString(),
            'schedule_time' => now()->addDays(1)->setTime(15, 30),
            'price' => 19.80,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 2,
            'movie_id' => 9,
            'show_date' => now()->addDays(1)->toDateString(),
            'schedule_time' => now()->addDays(1)->setTime(18, 0),
            'price' => 15.00,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 3,
            'movie_id' => 11,
            'show_date' => now()->addDays(1)->toDateString(),
            'schedule_time' => now()->addDays(1)->setTime(10, 30),
            'price' => 12.99,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 3,
            'movie_id' => 12,
            'show_date' => now()->addDays(1)->toDateString(),
            'schedule_time' => now()->addDays(1)->setTime(13, 0),
            'price' => 16.50,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 3,
            'movie_id' => 13,
            'show_date' => now()->addDays(1)->toDateString(),
            'schedule_time' => now()->addDays(1)->setTime(15, 30),
            'price' => 19.00,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 3,
            'movie_id' => 14,
            'show_date' => now()->addDays(1)->toDateString(),
            'schedule_time' => now()->addDays(1)->setTime(18, 0),
            'price' => 15.50,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 1,
            'movie_id' => 6,
            'show_date' => now()->toDateString(),
            'schedule_time' => now()->setTime(10, 30),
            'price' => 14.20,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 1,
            'movie_id' => 7,
            'show_date' => now()->toDateString(),
            'schedule_time' => now()->setTime(13, 0),
            'price' => 16.50,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 1,
            'movie_id' => 8,
            'show_date' => now()->toDateString(),
            'schedule_time' => now()->setTime(15, 30),
            'price' => 18.00,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 1,
            'movie_id' => 9,
            'show_date' => now()->toDateString(),
            'schedule_time' => now()->setTime(18, 0),
            'price' => 15.50,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 1,
            'movie_id' => 10,
            'show_date' => now()->toDateString(),
            'schedule_time' => now()->setTime(20, 30),
            'price' => 19.00,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 2,
            'movie_id' => 11,
            'show_date' => now()->toDateString(),
            'schedule_time' => now()->setTime(11, 0),
            'price' => 12.99,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 2,
            'movie_id' => 12,
            'show_date' => now()->toDateString(),
            'schedule_time' => now()->setTime(13, 30),
            'price' => 14.75,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 2,
            'movie_id' => 13,
            'show_date' => now()->toDateString(),
            'schedule_time' => now()->setTime(16, 0),
            'price' => 16.25,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 2,
            'movie_id' => 14,
            'show_date' => now()->toDateString(),
            'schedule_time' => now()->setTime(18, 30),
            'price' => 15.50,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 2,
            'movie_id' => 1,
            'show_date' => now()->toDateString(),
            'schedule_time' => now()->setTime(21, 0),
            'price' => 18.99,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 3,
            'movie_id' => 2,
            'show_date' => now()->toDateString(),
            'schedule_time' => now()->setTime(10, 0),
            'price' => 14.50,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 3,
            'movie_id' => 3,
            'show_date' => now()->toDateString(),
            'schedule_time' => now()->setTime(12, 30),
            'price' => 16.50,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 3,
            'movie_id' => 4,
            'show_date' => now()->toDateString(),
            'schedule_time' => now()->setTime(15, 0),
            'price' => 20.00,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 3,
            'movie_id' => 6,
            'show_date' => now()->toDateString(),
            'schedule_time' => now()->setTime(20, 0),
            'price' => 16.75,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 1,
            'movie_id' => 7,
            'show_date' => now()->addDays(1)->toDateString(),
            'schedule_time' => now()->addDays(1)->setTime(10, 30),
            'price' => 15.25,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 1,
            'movie_id' => 8,
            'show_date' => now()->addDays(1)->toDateString(),
            'schedule_time' => now()->addDays(1)->setTime(13, 0),
            'price' => 18.99,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 1,
            'movie_id' => 10,
            'show_date' => now()->addDays(1)->toDateString(),
            'schedule_time' => now()->addDays(1)->setTime(18, 0),
            'price' => 19.25,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 2,
            'movie_id' => 13,
            'show_date' => now()->addDays(1)->toDateString(),
            'schedule_time' => now()->addDays(1)->setTime(12, 30),
            'price' => 15.25,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 2,
            'movie_id' => 14,
            'show_date' => now()->addDays(1)->toDateString(),
            'schedule_time' => now()->addDays(1)->setTime(15, 0),
            'price' => 16.99,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 2,
            'movie_id' => 1,
            'show_date' => now()->addDays(1)->toDateString(),
            'schedule_time' => now()->addDays(1)->setTime(17, 30),
            'price' => 18.00,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 2,
            'movie_id' => 2,
            'show_date' => now()->addDays(1)->toDateString(),
            'schedule_time' => now()->addDays(1)->setTime(20, 0),
            'price' => 20.50,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 3,
            'movie_id' => 7,
            'show_date' => now()->addDays(1)->toDateString(),
            'schedule_time' => now()->addDays(1)->setTime(20, 30),
            'price' => 19.50,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 3,
            'movie_id' => 8,
            'show_date' => now()->addDays(2)->toDateString(),
            'schedule_time' => now()->addDays(2)->setTime(10, 0),
            'price' => 16.75,
            'status' => 'Active',
        ]);
        
        Schedule::create([
            'room_id' => 3,
            'movie_id' => 9,
            'show_date' => now()->addDays(2)->toDateString(),
            'schedule_time' => now()->addDays(2)->setTime(12, 30),
            'price' => 17.99,
            'status' => 'Active',
        ]);
                
        }
    }
