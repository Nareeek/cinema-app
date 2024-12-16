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
            'poster_url' => 'avatar2.jpg', // Relative path from public/
            'trailer_url' => 'https://www.youtube.com/watch?v=d9MyW72ELq0',
            'duration' => 180,
        ]);

        Movie::create([
            'title' => 'The Batman',
            'description' => 'A crimefighter operating in Gotham City, he serves as its protector, using the symbol of a bat to strike fear into the hearts of criminals.',
            'poster_url' => 'batman.jpg', // Relative path from public/
            'trailer_url' => 'https://www.youtube.com/watch?v=mqqft2x_Aa4',
            'duration' => 120,
        ]);

        Movie::create([
            'title' => 'Home Alone',
            'description' => 'A young boy who defends his suburban Chicago home from a home invasion by a pair of robbers after his family accidentally leaves him behind on their Christmas vacation to Paris',
            'poster_url' => 'home_alone.jgp.jpg', // Relative path from public/
            'trailer_url' => 'https://www.youtube.com/watch?v=jEDaVHmw7r4',
            'duration' => 100,
        ]);

        Movie::create([
            'title' => 'The GodFather',
            'description' => 'Focuses on the transformation of his youngest son, Michael Corleone (Pacino), from reluctant family outsider to ruthless mafia boss',
            'poster_url' => 'the_godfather.jpg', // Relative path from public/
            'trailer_url' => 'https://www.youtube.com/watch?v=UaVTIH8mujA',
            'duration' => 190,
        ]);

        Movie::create([
            'title' => 'Joker',
            'description' => 'A complete psychopath with no moral compass whatsoever',
            'poster_url' => 'joker.jpg', // Relative path from public/
            'trailer_url' => 'https://www.youtube.com/watch?v=_OKAwz2MsJs',
            'duration' => 210,
        ]);

        Movie::create([
            'title' => 'Harry Potter',
            'description' => 'A series of novels by British author J. K. Rowling.',
            'poster_url' => 'harry_potter.jpg', // Relative path from public/
            'trailer_url' => 'https://www.youtube.com/watch?v=_OKAwz2MsJs',
            'duration' => 150,
        ]);

        Movie::create([
            'title' => 'Christmas',
            'description' => 'A movie that has a plot that is dependent on the holiday season',
            'poster_url' => 'christmas.jpg', // Relative path from public/
            'trailer_url' => 'https://www.youtube.com/watch?v=_OKAwz2MsJs',
            'duration' => 250,
        ]);

        Movie::create([
            'title' => 'Amelie',
            'description' => 'A young waitress Amelie decides to help people find happiness',
            'poster_url' => 'amelie.jpg', // Relative path from public/
            'trailer_url' => 'https://www.youtube.com/watch?v=_OKAwz2MsJs',
            'duration' => 102,
        ]);

        Movie::create([
            'title' => 'The Silence of the Lambs (1991)',
            'description' => 'A young F.B.I. cadet must receive the help of an incarcerated and manipulative cannibal killer to help catch another serial killer, a madman who skins his victims',
            'poster_url' => 'the_silence_of_the_lambs.jpg', // Relative path from public/
            'trailer_url' => 'https://www.youtube.com/watch?v=_OKAwz2MsJs',
            'duration' => 150,
        ]);

        Movie::create([
            'title' => 'Avengers',
            'description' => 'A the planets first line of defense against the most powerful threats in the universe',
            'poster_url' => 'avengers.jpg', // Relative path from public/
            'trailer_url' => 'https://www.youtube.com/watch?v=_OKAwz2MsJs',
            'duration' => 200,
        ]);

        Movie::create([
            'title' => 'Dune',
            'description' => 'A mythic and emotionally charged heros journey',
            'poster_url' => 'dune.jpg', // Relative path from public/
            'trailer_url' => 'https://www.youtube.com/watch?v=_OKAwz2MsJs',
            'duration' => 200,
        ]);

        Movie::create([
            'title' => 'Venom',
            'description' => 'The poisonous fluid that some animals, as certain snakes and spiders, secrete and introduce into the bodies of their victims by biting, stinging',
            'poster_url' => 'venom.jpg', // Relative path from public/
            'trailer_url' => 'https://www.youtube.com/watch?v=_OKAwz2MsJs',
            'duration' => 150,
        ]);

        Movie::create([
            'title' => 'Moana',
            'description' => 'A strong-willed, independent wayfinder',
            'poster_url' => 'moana.jpg', // Relative path from public/
            'trailer_url' => 'https://www.youtube.com/watch?v=_OKAwz2MsJs',
            'duration' => 50,
        ]);

        Movie::create([
            'title' => 'Us',
            'description' => 'A strong horror film that will leave you scared, sad and even laughing at certain points',
            'poster_url' => 'us.jpg', // Relative path from public/
            'trailer_url' => 'https://www.youtube.com/watch?v=_OKAwz2MsJs',
            'duration' => 190,
        ]);
    }
}
