<?php

namespace Database\Seeders;

use App\Models\Cinemas;
use App\Models\Genres;
use App\Models\Halls;
use App\Models\Roles;
use App\Models\Seats;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // ── Roles ─────────────────────────────────────────────────────────────
        $adminRole    = Roles::firstOrCreate(['name' => 'admin']);
        $customerRole = Roles::firstOrCreate(['name' => 'customer']);

        // ── Users ─────────────────────────────────────────────────────────────
        User::firstOrCreate(
            ['email' => 'admin@cinemax.com'],
            [
                'name'         => 'Admin User',
                'password'     => Hash::make('password'),
                'role_id'      => $adminRole->id,
                'status'       => 'active',
                'avatar_color' => '#e8340a',
            ]
        );

        User::firstOrCreate(
            ['email' => 'customer@cinemax.com'],
            [
                'name'         => 'Test Customer',
                'password'     => Hash::make('password'),
                'role_id'      => $customerRole->id,
                'status'       => 'active',
                'avatar_color' => '#ff6b35',
            ]
        );

        // ── Genres ────────────────────────────────────────────────────────────
        $genreNames = [
            'Action', 'Adventure', 'Comedy', 'Drama', 'Fantasy',
            'Horror', 'Romance', 'Sci-Fi', 'Thriller', 'Animation',
        ];

        foreach ($genreNames as $name) {
            Genres::firstOrCreate(['name' => $name]);
        }

        // ── Cinemas ───────────────────────────────────────────────────────────
        $cinemaData = [
            ['name' => 'CineMax Downtown', 'location' => '123 Main St, City Center'],
            ['name' => 'CineMax Mall',     'location' => '456 Shopping Plaza, Mall Level 3'],
            ['name' => 'CineMax Luxury',   'location' => '789 Premium Ave, Uptown'],
        ];

        foreach ($cinemaData as $cinema) {
            Cinemas::firstOrCreate($cinema);
        }

        // ── Halls (3 per cinema) ──────────────────────────────────────────────
        $cinemas = Cinemas::all();
        foreach ($cinemas as $cinema) {
            for ($i = 1; $i <= 3; $i++) {
                Halls::firstOrCreate([
                    'name'      => "Hall {$i}",
                    'cinema_id' => $cinema->id,
                    'capacity'  => 100,
                ]);
            }
        }

        // ── Seats (10×10 grid per hall) ───────────────────────────────────────
        $halls = Halls::all();
        foreach ($halls as $hall) {
            for ($row = 1; $row <= 10; $row++) {
                $rowLetter = chr(64 + $row); // A–J
                for ($number = 1; $number <= 10; $number++) {
                    Seats::firstOrCreate([
                        'hall_id'    => $hall->id,
                        'row_number' => $rowLetter,
                        'number'     => $number,
                    ]);
                }
            }
        }

        $this->command->info('✓ Roles, users, genres, cinemas, halls, and seats seeded.');

        // ── Movies ────────────────────────────────────────────────────────────
        // MoviesSeeder inserts both now-showing and coming-soon movies.
        // Coming-soon movies have future release dates and NO showtimes.
        $this->call(MoviesSeeder::class);

        // ── Showtimes ─────────────────────────────────────────────────────────
        // ShowtimesSeeder assigns exactly ONE movie per hall for a 2-week run.
        // 3 screenings per day: 10:00 AM, 2:30 PM, 7:00 PM.
        // Only now-showing movies (first 12) get hall assignments.
        $this->call(ShowtimesSeeder::class);

        $this->command->info('');
        $this->command->info('✓ Database seeding complete.');
        $this->command->info('  Admin login:    admin@cinemax.com / password');
        $this->command->info('  Customer login: customer@cinemax.com / password');
    }
}
