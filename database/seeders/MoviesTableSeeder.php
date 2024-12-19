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
            'Avatar',
            'Black Panther',
            'Coco',
            'Find Nemo',
            'Frozen',
            'Gladiator',
            'Inception',
            'Interstellar',
            'Jurassic Park',
            'Shrek',
            'The Avengers',
            'The Dark Knight',
            'The Matrix',
            'Titanic',
            'Up',
            'The Lion King',
            'Forrest Gump',
            'The Shawshank Redemption',
            'Harry Potter and the Sorcerer\'s Stone',
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
            'movie-avengers.jpg',
            'movie-dark-knight.jpg',
            'movie-the-matrix.jpg',
            'movie-titanic.jpg',
            'movie-up.jpg',
            'movie-lion-king.jpg',
            'movie-forrest-gump.jpg',
            'movie-shawshank-redemption.jpg',
            'movie-harry-potter.jpg',
        ];

        // Corresponding movie descriptions
        $descriptions = [
            "A visually stunning sci-fi tale about an alien world and humanity's conflict.",
            "A Marvel superhero epic that explores African culture and leadership.",
            "A heartwarming animated story about family, music, and the Day of the Dead.",
            "An adventurous underwater journey of a father searching for his son.",
            "A magical tale of sisterhood and finding oneself in a snowy kingdom.",
            "A gripping historical drama of a Roman general turned gladiator.",
            "A mind-bending thriller about dreams within dreams.",
            "A sci-fi odyssey exploring space, time, and human survival.",
            "A groundbreaking dinosaur-filled adventure with thrilling suspense.",
            "A hilarious fairy-tale parody about an ogre's quest for love.",
            "A superhero ensemble saving the world from massive threats.",
            "A dark and gritty Batman film with a legendary villain.",
            "A revolutionary cyberpunk film about virtual reality and rebellion.",
            "A tragic love story set against the backdrop of a historic shipwreck.",
            "An emotional adventure of an old man and a boy on a flying house journey.",
            "A timeless animated tale of courage, family, and destiny.",
            "A heartwarming story of a simple man who influences history.",
            "A moving drama about hope and friendship in prison.",
            "The magical beginning of a young wizard's journey."
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
                'description' => $descriptions[$index],
            ]);
        }
    }
}
