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
            'storage/posters/movie-avatar.jpg',
            'storage/posters/movie-black-panther.jpg',
            'storage/posters/movie-coco.jpg',
            'storage/posters/movie-finding-nemo.jpg',
            'storage/posters/movie-frozen.jpg',
            'storage/posters/movie-gladiator.jpg',
            'storage/posters/movie-inception.jpg',
            'storage/posters/movie-interstellar.jpg',
            'storage/posters/movie-jurassic-park.jpg',
            'storage/posters/movie-shrek.jpg',
            'storage/posters/movie-avengers.jpg',
            'storage/posters/movie-dark-knight.jpg',
            'storage/posters/movie-the-matrix.jpg',
            'storage/posters/movie-titanic.jpg',
            'storage/posters/movie-up.jpg',
            'storage/posters/movie-lion-king.jpg',
            'storage/posters/movie-forrest-gump.jpg',
            'storage/posters/movie-shawshank-redemption.jpg',
            'storage/posters/movie-harry-potter.jpg',
        ];

        // Corresponding movie descriptions
        $descriptions = [
            'On the lush alien world of Pandora, ex-Marine Jake Sully is torn between the demands of his mission and his connection to the Na’vi people, who fight to protect their home from destruction. A visually stunning exploration of loyalty, love, and sacrifice.',
            'After the death of his father, T’Challa returns to Wakanda, a hidden but technologically advanced nation, to assume the throne. He must confront betrayal, moral dilemmas, and an adversary with a vision for global revolution. A powerful tale of legacy and leadership.',
            'Miguel, a young boy with a passion for music, finds himself in the colorful Land of the Dead. With the help of a charming trickster, he uncovers the truth about his family’s past and learns the value of remembering and celebrating those who came before.',
            'Marlin, a cautious clownfish, embarks on an epic journey across the ocean to rescue his adventurous son, Nemo, who has been captured by a diver. Along the way, he encounters unforgettable characters and discovers courage he never knew he had.',
            'When her kingdom is trapped in an eternal winter, young Anna teams up with a rugged ice seller, a magical snowman, and a reindeer to find her estranged sister, Elsa, whose icy powers are the key to saving their home. A heartwarming story of family and forgiveness.',
            'Betrayed and enslaved, former Roman General Maximus Decimus Meridius rises through the ranks of gladiators to seek revenge against the corrupt emperor who destroyed his family. A gripping tale of honor, vengeance, and resilience.',
            'Dom Cobb, a skilled thief who specializes in extracting secrets from dreams, is tasked with planting an idea into the mind of a corporate heir. As his team delves deeper into shared dream layers, the line between reality and illusion blurs dangerously.',
            'A group of scientists and astronauts travel through a wormhole near Saturn in search of a new habitable planet for humanity. As time and gravity test their resolve, the mission becomes a race against extinction and the limits of love and endurance.',
            'A trip to an island theme park filled with living dinosaurs turns deadly when a power failure releases the creatures from their enclosures. A thrilling adventure about science, chaos, and survival in a world where nature is both awe-inspiring and terrifying.',
            'When his swamp is overrun by fairy-tale creatures, the grumpy ogre Shrek reluctantly agrees to rescue Princess Fiona from a dragon-guarded tower. Along the way, he learns the true meaning of friendship and love, with plenty of laughs along the way.',
            'Earth’s mightiest heroes—including Iron Man, Thor, and Captain America—must unite to stop Loki, the god of mischief, from using a powerful energy source to enslave humanity. A high-stakes battle for the planet’s future unfolds with epic action and teamwork.',
            'Gotham’s vigilante, Batman, faces his greatest challenge yet when the Joker, a criminal mastermind, unleashes chaos across the city. The battle tests Batman’s resolve and his code of morality, pushing him to the limits in a gripping fight against terror.',
            'Neo, a computer hacker, discovers that his reality is a simulated world controlled by machines. He joins a group of rebels to fight for humanity’s freedom, uncovering his own potential as "The One" in a groundbreaking journey through philosophy and action.',
            'Aboard the ill-fated Titanic, young aristocrat Rose finds love with Jack, a free-spirited artist from a different social class. Their romance blossoms amid the ship’s luxurious splendor, but tragedy strikes when it collides with an iceberg on its maiden voyage.',
            'Carl, a widower yearning for adventure, ties thousands of balloons to his house and sets off for South America. Alongside Russell, an eager boy scout, he discovers unexpected friendship and a thrilling journey that reignites his zest for life.',
            'Simba, a young lion prince, flees his kingdom after his father’s death and lives in exile. Guided by the lessons of his past and the love of his friends, he returns to face his destiny and take back his rightful place as king in a timeless tale of redemption.',
            'Forrest Gump, a kind-hearted man with a simple perspective on life, inadvertently becomes involved in some of the most significant events of the 20th century. His journey reveals the beauty of love, friendship, and the power of perseverance.',
            'Andy Dufresne, wrongly imprisoned for murder, forms an unlikely friendship with fellow inmate Red. Over decades, their bond grows, culminating in acts of hope, redemption, and one of the most inspiring escapes in cinematic history.',
            'Harry Potter, an orphan raised by neglectful relatives, discovers on his 11th birthday that he is a wizard. At Hogwarts School of Witchcraft and Wizardry, he makes lifelong friends and confronts dark secrets about his family and destiny.',
        ];        

        $movieTrailers = [
            'https://www.youtube.com/watch?v=5PSNL1qE6VY',
            'https://www.youtube.com/watch?v=xjDjIWPwcPU',
            'https://www.youtube.com/watch?v=Rvr68u6k5sI',
            'https://www.youtube.com/watch?v=wZdpNglLbt8',
            'https://www.youtube.com/watch?v=TbQm5doF_Uc',
            'https://www.youtube.com/watch?v=owK1qxDselE',
            'https://www.youtube.com/watch?v=8hP9D6kZseM',
            'https://www.youtube.com/watch?v=zSWdZVtXT7E',
            'https://www.youtube.com/watch?v=QWBKEmWWL38',
            'https://www.youtube.com/watch?v=W37DlG1i61s',
            'https://www.youtube.com/watch?v=eOrNdBpGMv8',
            'https://www.youtube.com/watch?v=EXeTwQWrcwY',
            'https://www.youtube.com/watch?v=vKQi3bBA1y8',
            'https://www.youtube.com/watch?v=kVrqfYjkTdQ',
            'https://www.youtube.com/watch?v=pkqzFUhGPJg',
            'https://www.youtube.com/watch?v=7TavVZMewpY',
            'https://www.youtube.com/watch?v=bLvqoHBptjg',
            'https://www.youtube.com/watch?v=6hB3S9bIaco',
            'https://www.youtube.com/watch?v=VyHV0BRtdxo',
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
                'trailer_url' => $movieTrailers[$index],
            ]);
        }
    }
}
