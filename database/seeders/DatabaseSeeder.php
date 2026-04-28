<?php

namespace Database\Seeders;

use App\Models\Bookings;
use App\Models\Bookings_seats;
use App\Models\Cinemas;
use App\Models\Genres;
use App\Models\Halls;
use App\Models\Movies;
use App\Models\Payments;
use App\Models\Roles;
use App\Models\Seats;
use App\Models\Showtimes;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Roles::firstOrCreate(['name' => 'admin']);
        $customerRole = Roles::firstOrCreate(['name' => 'customer']);

        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@cinemax.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
                'status' => 'active',
                'avatar_color' => '#e8340a',
            ]
        );

        // Create test customer
        User::firstOrCreate(
            ['email' => 'customer@cinemax.com'],
            [
                'name' => 'Test Customer',
                'password' => Hash::make('password'),
                'role_id' => $customerRole->id,
                'status' => 'active',
                'avatar_color' => '#ff6b35',
            ]
        );

        // Create genres
        $genres = [
            ['name' => 'Action'],
            ['name' => 'Adventure'],
            ['name' => 'Comedy'],
            ['name' => 'Drama'],
            ['name' => 'Fantasy'],
            ['name' => 'Horror'],
            ['name' => 'Romance'],
            ['name' => 'Sci-Fi'],
            ['name' => 'Thriller'],
            ['name' => 'Animation'],
        ];

        foreach ($genres as $genre) {
            Genres::firstOrCreate($genre);
        }

        // Create cinemas
        $cinemas = [
            ['name' => 'CineMax Downtown', 'location' => '123 Main St, City Center'],
            ['name' => 'CineMax Mall', 'location' => '456 Shopping Plaza, Mall Level 3'],
            ['name' => 'CineMax Luxury', 'location' => '789 Premium Ave, Uptown'],
        ];

        foreach ($cinemas as $cinema) {
            Cinemas::firstOrCreate($cinema);
        }

        // Create halls for each cinema
        $cinemas = Cinemas::all();
        foreach ($cinemas as $cinema) {
            for ($i = 1; $i <= 3; $i++) {
                Halls::firstOrCreate([
                    'name' => "Hall {$i}",
                    'cinema_id' => $cinema->id,
                    'capacity' => 100,
                ]);
            }
        }

        // Create seats for each hall (10x10 grid)
        $halls = Halls::all();
        foreach ($halls as $hall) {
            for ($row = 1; $row <= 10; $row++) {
                $rowLetter = chr(64 + $row); // A, B, C, etc.
                for ($number = 1; $number <= 10; $number++) {
                    Seats::firstOrCreate([
                        'hall_id' => $hall->id,
                        'row_number' => $rowLetter,
                        'number' => $number,
                    ]);
                }
            }
        }

        $this->call(MoviesSeeder::class);

        // Create showtimes for movies
        $movies = Movies::all();
        $halls = Halls::all();

        foreach ($movies as $movie) {
            // Create 2-3 showtimes per movie per hall
            foreach ($halls->random(min(2, $halls->count())) as $hall) {
                $startTime = now()->addDays(rand(0, 7))->setHour(rand(10, 22))->setMinute(0);
                $endTime = $startTime->copy()->addMinutes($movie->duration);

                // Set prices based on movie genre and popularity (Philippine Peso)
                $basePrice = match($movie->genre->name) {
                    'Action', 'Adventure', 'Sci-Fi', 'Fantasy' => rand(350, 450), // Blockbusters
                    'Animation' => rand(300, 400), // Family movies
                    'Drama', 'Romance', 'Comedy' => rand(250, 350), // Regular movies
                    'Horror', 'Thriller' => rand(280, 380), // Genre movies
                    default => rand(250, 350)
                };

                Showtimes::firstOrCreate([
                    'movie_id' => $movie->id,
                    'hall_id' => $hall->id,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'price' => $basePrice,
                ]);
            }
        }
    }
}
