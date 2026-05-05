<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Movies;
use App\Models\Reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request, Movies $movie)
    {
        $request->validate([
            'rating'  => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string', 'max:1000'],
        ]);

        $userId = Auth::id();

        // Check the user has a confirmed booking for this movie whose showtime has ended
        $eligibleBooking = Bookings::where('user_id', $userId)
            ->where('status', 'confirmed')
            ->whereHas('showtime', function ($q) use ($movie) {
                $q->where('movie_id', $movie->id)
                  ->where('end_time', '<=', Carbon::now());
            })
            ->first();

        if (!$eligibleBooking) {
            return redirect()->route('movies.show', $movie)
                ->with('error', 'You can only review a movie after you have watched it (booking confirmed and showtime ended).');
        }

        // Prevent duplicate reviews
        $alreadyReviewed = Reviews::where('user_id', $userId)
            ->where('movie_id', $movie->id)
            ->exists();

        if ($alreadyReviewed) {
            return redirect()->route('movies.show', $movie)
                ->with('error', 'You have already submitted a review for this movie.');
        }

        Reviews::create([
            'user_id'  => $userId,
            'movie_id' => $movie->id,
            'rating'   => $request->rating,
            'comment'  => $request->comment,
        ]);

        return redirect()->route('movies.show', $movie)->with('success', 'Your review has been posted!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reviews $reviews)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reviews $reviews)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reviews $reviews)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reviews $reviews)
    {
        //
    }
}
