<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Movie;
use Illuminate\Database\Seeder;

class MoviesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Movie::create([
            'title' => 'Avatar 2',
            'description' => 'An epic science fiction film directed by James Cameron',
            'poster_url' => '/images/avatar2.jpg', // Relative path from public/
            'trailer_url' => 'https://www.youtube.com/watch?v=d9MyW72ELq0',
            'duration' => 180,
        ]);

        Movie::create([
            'title' => 'The Batman',
            'description' => 'A thrilling superhero film starring Robert Pattinson',
            'poster_url' => '/images/batman.jpg', // Relative path from public/
            'trailer_url' => 'https://youtube.com/trailer_batman',
            'duration' => 150,
        ]);
    }
}
