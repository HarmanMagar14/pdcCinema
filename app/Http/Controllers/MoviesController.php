<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Cinemas;
use App\Models\Movies;
use App\Models\Reviews;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');
        $status = request('status');

        $query = Movies::with('genre', 'nextShowtime')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('genre', function ($genreQuery) use ($search) {
                      $genreQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($status === 'now-showing') {
            $query->whereHas('showtime', function($q) {
                $q->whereDate('start_time', '=', Carbon::today());
            });
        } elseif ($status === 'coming-soon') {
            $query->whereHas('showtime', function($q) {
                $q->whereDate('start_time', '>', Carbon::today());
            });
        }

        $movies = $query->get();
        return view('movies.index', compact('movies', 'search', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Movies $movie)
    {
        $now = \Carbon\Carbon::now();
        $showtimes = $movie->showtimes()->with('hall.cinema')->get();
        
        // Only show cinemas that have showtimes for this movie
        $cinemaIds = $showtimes->pluck('hall.cinema_id')->filter()->unique();
        $cinemas = Cinemas::whereIn('id', $cinemaIds)->orderBy('name')->get();
        
        $reviews = $movie->reviews()->with('user')->latest()->get();
        $averageRating = $movie->reviews()->avg('rating');
        $reviewCount = $movie->reviews()->count();

        // ── Review eligibility ─────────────────────────────────────────────────────
        $canReview      = false;
        $alreadyReviewed = false;
        $reviewableAfter = null; // earliest end_time for a confirmed booking (future or past)

        if (Auth::check()) {
            $userId = Auth::id();

            // Has the user already reviewed this movie?
            $alreadyReviewed = Reviews::where('user_id', $userId)
                ->where('movie_id', $movie->id)
                ->exists();

            if (!$alreadyReviewed) {
                // Find user's confirmed bookings for this movie where the showtime has ALREADY ENDED
                $eligibleBookings = Bookings::where('user_id', $userId)
                    ->where('status', 'confirmed')
                    ->whereHas('showtime', function ($q) use ($movie) {
                        $q->where('movie_id', $movie->id)
                          ->where('end_time', '<=', Carbon::now()); // showtime must have ended
                    })
                    ->with('showtime')
                    ->get();

                if ($eligibleBookings->isNotEmpty()) {
                    $canReview = true;
                    $reviewableAfter = null;
                } else {
                    // Check if user has a future/ongoing confirmed booking (to show the countdown)
                    $futureBooking = Bookings::where('user_id', $userId)
                        ->where('status', 'confirmed')
                        ->whereHas('showtime', function ($q) use ($movie) {
                            $q->where('movie_id', $movie->id)
                              ->where('end_time', '>', Carbon::now()); // showtime hasn't ended yet
                        })
                        ->with('showtime')
                        ->get();

                    if ($futureBooking->isNotEmpty()) {
                        // Show unlock countdown: use the earliest upcoming end_time
                        $reviewableAfter = $futureBooking->min(fn($b) => $b->showtime->end_time);
                    }
                }
            }
        }
        // ── End review eligibility ─────────────────────────────────────────────────

        // Transform data for JavaScript
        $cinemaToHalls = $showtimes
            ->filter(fn($showtime) => $showtime->hall && $showtime->hall->cinema)
            ->groupBy(fn($showtime) => (string)$showtime->hall->cinema->id)
            ->map(function ($cinemaShowtimes) {
                return $cinemaShowtimes
                    ->map(fn($showtime) => [
                        'id'   => $showtime->hall->id,
                        'name' => $showtime->hall->name,
                    ])
                    ->unique('id')
                    ->values()
                    ->all();
            })
            ->all();

        $hallToShowtime = $showtimes
            ->filter(fn($showtime) => $showtime->hall)
            ->groupBy(fn($showtime) => (string)$showtime->hall->id)
            ->map(function ($hallShowtimes) use ($now) {
                // Prefer the earliest upcoming/active showtime; fall back to the last past one
                $upcoming = $hallShowtimes->filter(fn($s) => $s->end_time > $now)->sortBy('start_time');
                $chosen   = $upcoming->first() ?? $hallShowtimes->sortByDesc('start_time')->first();
                return optional($chosen)->id;
            })
            ->all();

        return view('movies.show', compact(
            'movie', 'showtimes', 'cinemas', 'reviews', 'averageRating', 'reviewCount',
            'cinemaToHalls', 'hallToShowtime',
            'canReview', 'alreadyReviewed', 'reviewableAfter'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movies $movies)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movies $movies)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movies $movies)
    {
        //
    }
}
