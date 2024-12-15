<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Movie;

class MoviesTableSeeder extends Seeder
{
    public function run()
    {
        // Array of movie names
        $movieNames = [
            'The Avengers',
            'Titanic',
            'Inception',
            'The Dark Knight',
            'Frozen',
            'Interstellar',
            'The Lion King',
            'Forrest Gump',
            'The Matrix',
            'Avatar',
            'The Shawshank Redemption',
            'Jurassic Park',
            'Harry Potter and the Sorcerer\'s Stone',
            'Black Panther',
            'Coco',
        ];

        // Corresponding poster URLs
        $posterUrls = [
            'movie-avatar.jpg',
            'movie-black-panther.jpg',
            'movie-coco.jpg',
            'movie-finding-nemo.jpg',
            'movie-frozen.jpg',
            'movie-gladiator.jpg',
            'movie-inception.jpg',
            'movie-interstellar.jpg',
            'movie-jurassic-park.jpg',
            'movie-shrek.jpg',
            'movie-the-avengers.jpg',
            'movie-the-dark-knight.jpg',
            'movie-the-matrix.jpg',
            'movie-titanic.jpg',
            'movie-up.jpg',
            'movie-the-lion-king.jpg',
            'movie-forrest-gump.jpg',
            'movie-the-shawshank-redemption.jpg',
            'movie-harry-potter.jpg',
        ];

        // Loop through movie names and seed the database
        foreach ($movieNames as $index => $name) {
            Movie::create([
                'title' => $name,
                'duration' => rand(90, 180), // Random duration between 90 and 180 minutes
                'rating' => ['G', 'PG', 'PG-13', 'R'][array_rand(['G', 'PG', 'PG-13', 'R'])], // Random rating
                'genre' => ['Action', 'Comedy', 'Drama', 'Sci-Fi', 'Fantasy', 'Animation'][array_rand(['Action', 'Comedy', 'Drama', 'Sci-Fi', 'Fantasy', 'Animation'])], // Random genre
                'slug' => Str::slug($name),
                'poster_url' => $posterUrls[$index],
            ]);
        }
    }
}
