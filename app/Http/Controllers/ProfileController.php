<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        $bookings = $user->bookings()
            ->with(['showtime.movie.genre', 'showtime.hall.cinema', 'payment', 'tickets'])
            ->get();

        $bookedMovies = $bookings
            ->filter(function ($booking) {
                return $booking->status !== 'canceled'
                    && $booking->showtime
                    && $booking->showtime->start_time
                    && $booking->showtime->start_time->greaterThanOrEqualTo(Carbon::now());
            })
            ->sortBy('showtime.start_time')
            ->values();

        $watchedMovies = $bookings
            ->filter(function ($booking) {
                $paid = optional($booking->payment)->status === 'paid';
                return $booking->status !== 'canceled'
                    && $paid
                    && $booking->showtime
                    && $booking->showtime->start_time
                    && $booking->showtime->start_time->lt(Carbon::now());
            })
            ->sortByDesc('showtime.start_time')
            ->values();

        return view('profile.show', compact('user', 'bookedMovies', 'watchedMovies'));
    }
}
