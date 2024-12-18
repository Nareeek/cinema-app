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

        // Corresponding poster URLs
        $descriptions = [
            "A visually stunning tale of a human who joins an alien race to protect their world from destruction.",
            "A hero rises to unite his nation and fight for the survival of his people against overwhelming odds.",
            "A young boy journeys to the Land of the Dead to uncover the secrets of his family history and love of music.",
            "A clownfish embarks on a thrilling ocean adventure to rescue his son and discovers courage along the way.",
            "Two sisters learn about love, sacrifice, and the power of self-acceptance in a frozen kingdom.",
            "A betrayed Roman general fights for justice and freedom in the blood-soaked arenas of ancient Rome.",
            "A mind-bending heist unfolds within the layers of dreams, pushing the limits of perception and reality.",
            "A father and daughter explore the cosmos and confront humanity’s survival through wormholes and time.",
            "Dinosaurs come to life in a thrilling, cautionary tale of science gone awry in a theme park.",
            "An ogre and his unlikely friends embark on a hilarious adventure to rescue a princess and discover true love.",
            "Earth's mightiest heroes assemble to save the world from a cosmic threat in an action-packed battle.",
            "A dark, gritty battle between a relentless vigilante and a chaotic criminal mastermind in Gotham City.",
            "A hacker discovers a hidden reality and becomes humanity’s last hope against a dystopian machine-controlled future.",
            "An epic romance and tragedy unfold aboard a doomed luxury liner in one of history’s greatest disasters.",
            "A widower and a young scout travel in a house lifted by balloons, searching for adventure and meaning.",
            "A lion prince’s journey of self-discovery leads him to reclaim his throne and restore the balance of his kingdom.",
            "A man with a simple heart lives through extraordinary events, showing that life is like a box of chocolates.",
            "An inspiring tale of hope and friendship as a man finds redemption within the walls of a brutal prison.",
            "A young boy discovers a magical world of wizards, danger, and friendship in his quest to become a hero."
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
