<?php

namespace Database\Seeders;

use App\Models\Cinemas;
use App\Models\Halls;
use App\Models\Movies;
use App\Models\Genres;
use App\Models\Showtimes;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ShowtimesSeeder extends Seeder
{
    /**
     * Seed organized showtimes for now-showing movies.
     *
     * Logic:
     *  - 3 cinemas, each with 3 halls = 9 halls total
     *  - Each hall is assigned exactly ONE movie for a 2-week run
     *  - Each hall runs 3 screenings per day: morning, afternoon, evening
     *  - No two movies share the same hall on the same day
     *  - Screening times are consistent across the entire 2-week run
     */
    public function run(): void
    {
        // Clear existing showtimes to avoid conflicts
        //Showtimes::truncate();

        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Showtimes::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $halls    = Halls::with('cinema')->get();
        $movies   = Movies::with('genre')->get();
        $today    = Carbon::today();
        $runDays  = 14; // 2-week span

        if ($halls->isEmpty() || $movies->isEmpty()) {
            $this->command->warn('No halls or movies found. Run DatabaseSeeder first.');
            return;
        }

        // ── Assign one movie per hall ─────────────────────────────────────────
        // We have 9 halls. Pick 9 different movies for now-showing.
        // The movies seeder already marked which ones have near release dates
        // as coming soon — here we just pick from what's available.
        $nowShowingMovies = $movies->shuffle()->take($halls->count());

        // Screening start times for each of the 3 daily slots (24h format)
        // These are the same every day for the entire 2-week run.
        $dailySlots = [
            ['hour' => 10, 'minute' => 0],   // 10:00 AM
            ['hour' => 14, 'minute' => 30],  // 2:30 PM
            ['hour' => 19, 'minute' => 0],   // 7:00 PM
        ];

        // Prices by genre
        $priceMap = [
            'Action'    => 420,
            'Adventure' => 420,
            'Sci-Fi'    => 400,
            'Fantasy'   => 400,
            'Animation' => 380,
            'Thriller'  => 370,
            'Horror'    => 360,
            'Drama'     => 330,
            'Romance'   => 320,
            'Comedy'    => 320,
        ];

        $created = 0;

        foreach ($halls as $hallIndex => $hall) {
            // Each hall gets one movie
            $movie = $nowShowingMovies->get($hallIndex);
            if (!$movie) continue;

            $price = $priceMap[$movie->genre->name ?? ''] ?? 350;

            // Run for 14 days from today
            for ($day = 0; $day < $runDays; $day++) {
                $date = $today->copy()->addDays($day);

                foreach ($dailySlots as $slot) {
                    $startTime = $date->copy()
                        ->setHour($slot['hour'])
                        ->setMinute($slot['minute'])
                        ->setSecond(0);

                    $endTime = $startTime->copy()->addMinutes($movie->duration);

                    // Safety check — skip if end time goes past midnight
                    if ($endTime->day !== $startTime->day) {
                        continue;
                    }

                    Showtimes::create([
                        'movie_id'   => $movie->id,
                        'hall_id'    => $hall->id,
                        'start_time' => $startTime,
                        'end_time'   => $endTime,
                        'price'      => $price,
                    ]);

                    $created++;
                }
            }

            $this->command->info(
                "Hall {$hall->name} ({$hall->cinema->name}) → {$movie->title} — " .
                ($runDays * count($dailySlots)) . " screenings"
            );
        }

        $this->command->info("✓ Total showtimes created: {$created}");
    }
}
