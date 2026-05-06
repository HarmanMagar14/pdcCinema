<?php

namespace Database\Seeders;

use App\Models\Genres;
use App\Models\Movies;
use Illuminate\Database\Seeder;

class MoviesSeeder extends Seeder
{
    /**
     * Seed movies split into two clear groups:
     *
     *  NOW SHOWING  (12 movies) — release dates in the past, shown on the
     *                             main grid and assigned hall schedules by
     *                             ShowtimesSeeder.
     *
     *  COMING SOON  (6 movies)  — release dates in the future, no showtimes,
     *                             they populate the hero carousel on the
     *                             welcome page via the comingSoonMovies query.
     *
     * How the welcome page decides which group a movie belongs to:
     *   - comingSoonMovies → Movies that have NO showtimes yet (future release)
     *   - now-showing grid → Movies that DO have showtimes
     *
     * NOTE: There is no 'status' column in the movies table.
     * The distinction is purely based on whether showtimes exist.
     */
    public function run(): void
    {
        // ── NOW SHOWING — 12 movies ───────────────────────────────────────────
        // These will be assigned to halls by ShowtimesSeeder.
        $nowShowing = [
            [
                'title'        => 'The Dark Knight',
                'description'  => 'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham, Batman must accept one of the greatest psychological and physical tests of his ability to fight injustice.',
                'genre'        => 'Action',
                'duration'     => 152,
                'release_date' => '2008-07-18',
                'poster'       => 'storage/posters/the-dark-knight.jpg',
                'trailer_url'  => 'https://www.youtube.com/watch?v=EXeTwQWrcwY',
            ],
            [
                'title'        => 'Inception',
                'description'  => 'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O.',
                'genre'        => 'Sci-Fi',
                'duration'     => 148,
                'release_date' => '2010-07-16',
                'poster'       => 'storage/posters/Inception.jpg',
                'trailer_url'  => 'https://www.youtube.com/watch?v=YoHD9XEInc0',
            ],
            [
                'title'        => 'The Shawshank Redemption',
                'description'  => 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.',
                'genre'        => 'Drama',
                'duration'     => 142,
                'release_date' => '1994-09-23',
                'poster'       => 'storage/posters/The Shawshank Redemption.jpg',
                'trailer_url'  => 'https://www.youtube.com/watch?v=PLl99DlL6b4',
            ],
            [
                'title'        => 'Interstellar',
                'description'  => 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity\'s survival.',
                'genre'        => 'Sci-Fi',
                'duration'     => 169,
                'release_date' => '2014-11-07',
                'poster'       => 'storage/posters/Interstellar.jpg',
                'trailer_url'  => 'https://www.youtube.com/watch?v=zSWdZVtXT7E',
            ],
            [
                'title'        => 'The Avengers',
                'description'  => 'Earth\'s mightiest heroes must come together and learn to fight as a team if they are going to stop the mischievous Loki and his alien army from enslaving humanity.',
                'genre'        => 'Action',
                'duration'     => 143,
                'release_date' => '2012-05-04',
                'poster'       => 'storage/posters/The Avengers.jpg',
                'trailer_url'  => 'https://www.youtube.com/watch?v=eOrNdBpGMv8',
            ],
            [
                'title'        => 'Avengers: Endgame',
                'description'  => 'After the devastating events of Infinity War, the universe is in ruins. The remaining Avengers assemble once more in order to restore balance.',
                'genre'        => 'Action',
                'duration'     => 181,
                'release_date' => '2019-04-26',
                'poster'       => 'storage/posters/Avengers Endgame.jpg',
                'trailer_url'  => 'https://www.youtube.com/watch?v=TcMBFSGVi1c',
            ],
            [
                'title'        => 'Inside Out 2',
                'description'  => 'Riley\'s headquarters is undergoing a sudden demolition to make room for something entirely unexpected: new Emotions!',
                'genre'        => 'Animation',
                'duration'     => 96,
                'release_date' => '2024-06-14',
                'poster'       => 'storage/posters/Inside Out 2.jpg',
                'trailer_url'  => 'https://www.youtube.com/watch?v=LEjhY26A66m',
            ],
            [
                'title'        => 'Deadpool & Wolverine',
                'description'  => 'A weary Wolverine finds himself recovering from his injuries when he crosses paths with the loudmouth Deadpool.',
                'genre'        => 'Action',
                'duration'     => 128,
                'release_date' => '2024-07-26',
                'poster'       => 'storage/posters/Deadpool & Wolverine.jpg',
                'trailer_url'  => 'https://www.youtube.com/watch?v=73_1biulkYk',
            ],
            [
                'title'        => 'Wicked: Part 1',
                'description'  => 'The story of how a green-skinned woman framed by the Wizard of Oz becomes the Wicked Witch of the West.',
                'genre'        => 'Fantasy',
                'duration'     => 160,
                'release_date' => '2024-11-22',
                'poster'       => 'storage/posters/Wicked Part 1.jpg',
                'trailer_url'  => 'https://www.youtube.com/watch?v=6COmYeLsz4c',
            ],
            [
                'title'        => 'Gladiator II',
                'description'  => 'Years after witnessing the death of the revered hero Maximus, Lucius is forced to enter the Colosseum to restore the glory of Rome.',
                'genre'        => 'Action',
                'duration'     => 148,
                'release_date' => '2024-11-22',
                'poster'       => 'storage/posters/Gladiator II.jpg',
                'trailer_url'  => 'https://www.youtube.com/watch?v=vV_fE6j7v7A',
            ],
            [
                'title'        => 'The Conjuring',
                'description'  => 'Paranormal investigators Ed and Lorraine Warren work to help a family terrorized by a dark presence in their farmhouse.',
                'genre'        => 'Horror',
                'duration'     => 112,
                'release_date' => '2013-07-19',
                'poster'       => 'storage/posters/The Conjuring.jpg',
                'trailer_url'  => 'https://www.youtube.com/watch?v=k10ETZ41q5o',
            ],
            [
                'title'        => 'Parasite',
                'description'  => 'Greed and class discrimination threaten the newly formed symbiotic relationship between the wealthy Park family and the destitute Kim clan.',
                'genre'        => 'Thriller',
                'duration'     => 132,
                'release_date' => '2019-05-30',
                'poster'       => 'storage/posters/Parasite.jpg',
                'trailer_url'  => 'https://www.youtube.com/watch?v=5xH0HfJHsaY',
            ],
        ];

        // ── COMING SOON — 6 movies ────────────────────────────────────────────
        // Future release dates, NO showtimes assigned.
        // These appear in the hero carousel on the welcome page.
        $comingSoon = [
            [
                'title'        => 'Avengers: Doomsday',
                'description'  => 'Earth\'s Mightiest Heroes face a new multidimensional threat as Victor von Doom makes his presence known across the multiverse.',
                'genre'        => 'Action',
                'duration'     => 150,
                'release_date' => '2026-12-18',
                'poster'       => 'storage/posters/Avengers Doomsday.jpg',
                'trailer_url'  => 'https://www.youtube.com/watch?v=A-A-A-A-A-A',
            ],
            [
                'title'        => 'The Legend of Zelda',
                'description'  => 'A live-action adaptation where Link must embark on a quest across Hyrule to rescue Princess Zelda and stop the dark wizard Ganon.',
                'genre'        => 'Fantasy',
                'duration'     => 135,
                'release_date' => '2027-05-07',
                'poster'       => 'storage/posters/The Legend of Zelda.jpg',
                'trailer_url'  => 'https://www.youtube.com/watch?v=Z-Z-Z-Z-Z-Z',
            ],
            [
                'title'        => 'The Super Mario Galaxy Movie',
                'description'  => 'Mario and the gang head to the stars to stop Bowser\'s ambitions for cosmic domination, introducing fan-favorites like Rosalina.',
                'genre'        => 'Animation',
                'duration'     => 105,
                'release_date' => '2027-04-01',
                'poster'       => 'storage/posters/The Super Mario Galaxy Movie.jpeg',
                'trailer_url'  => 'https://www.youtube.com/watch?v=S080S080S08',
            ],
            [
                'title'        => 'Michael',
                'description'  => 'A sweeping musical biopic charting Michael Jackson\'s journey from child stardom in the Jackson 5 to becoming the "King of Pop".',
                'genre'        => 'Drama',
                'duration'     => 158,
                'release_date' => '2026-10-24',
                'poster'       => 'storage/posters/Michael.jpg',
                'trailer_url'  => 'https://www.youtube.com/watch?v=M-M-M-M-M-M',
            ],
            [
                'title'        => 'Harry Potter and the Philosopher\'s Stone',
                'description'  => 'An orphaned boy enrolls in a school of wizardry, where he learns the truth about himself, his family and the terrible evil that haunts the magical world.',
                'genre'        => 'Fantasy',
                'duration'     => 152,
                'release_date' => '2026-11-16',
                'poster'       => 'storage/posters/Harry Potter and the Philosopher\'s Stone.jpg',
                'trailer_url'  => 'https://www.youtube.com/watch?v=VyHV0BRtdxo',
            ],
            [
                'title'        => 'The Lord of the Rings: The Fellowship of the Ring',
                'description'  => 'A meek Hobbit from the Shire and eight companions set out on a journey to destroy the powerful One Ring and save Middle-earth from the Dark Lord Sauron.',
                'genre'        => 'Fantasy',
                'duration'     => 178,
                'release_date' => '2026-09-19',
                'poster'       => 'storage/posters/The Lord of the Rings The Fellowship of the Ring.jpg',
                'trailer_url'  => 'https://www.youtube.com/watch?v=V75dMMIW2B4',
            ],
        ];

        // Insert now-showing movies
        foreach ($nowShowing as $data) {
            $genre = Genres::where('name', $data['genre'])->first();
            if (!$genre) continue;

            Movies::updateOrCreate(
                ['title' => $data['title']],
                [
                    'description'  => $data['description'],
                    'genre_id'     => $genre->id,
                    'duration'     => $data['duration'],
                    'release_date' => $data['release_date'],
                    'poster'       => $data['poster'],
                    'trailer_url'  => $data['trailer_url'],
                ]
            );
        }

        $this->command->info('✓ Now Showing movies seeded: ' . count($nowShowing));

        // Insert coming soon movies
        foreach ($comingSoon as $data) {
            $genre = Genres::where('name', $data['genre'])->first();
            if (!$genre) continue;

            Movies::updateOrCreate(
                ['title' => $data['title']],
                [
                    'description'  => $data['description'],
                    'genre_id'     => $genre->id,
                    'duration'     => $data['duration'],
                    'release_date' => $data['release_date'],
                    'poster'       => $data['poster'],
                    'trailer_url'  => $data['trailer_url'],
                ]
            );
        }

        $this->command->info('✓ Coming Soon movies seeded: ' . count($comingSoon));
    }
}
