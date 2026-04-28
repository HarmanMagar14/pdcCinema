<?php

namespace App\Http\Controllers;

use App\Models\Cinemas;
use App\Models\Movies;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');
        $status = request('status');

        $query = Movies::with('genre')
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
        $showtimes = $movie->showtimes()->with('hall.cinema')->get();
        
        // Only show cinemas that have showtimes for this movie
        $cinemaIds = $showtimes->pluck('hall.cinema_id')->filter()->unique();
        $cinemas = Cinemas::whereIn('id', $cinemaIds)->orderBy('name')->get();
        
        $reviews = $movie->reviews()->with('user')->latest()->get();
        $averageRating = $movie->reviews()->avg('rating');
        $reviewCount = $movie->reviews()->count();

        // Transform data for JavaScript
        $cinemaToHalls = $showtimes
            ->filter(fn($showtime) => $showtime->hall && $showtime->hall->cinema)
            ->groupBy(fn($showtime) => (string)$showtime->hall->cinema->id)
            ->map(function ($cinemaShowtimes) {
                return $cinemaShowtimes
                    ->map(fn($showtime) => [
                        'id' => $showtime->hall->id,
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
            ->map(fn($hallShowtimes) => optional($hallShowtimes->sortBy('start_time')->first())->id)
            ->all();

        return view('movies.show', compact('movie', 'showtimes', 'cinemas', 'reviews', 'averageRating', 'reviewCount', 'cinemaToHalls', 'hallToShowtime'));
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
