<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Reviews;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        $bookings = $user->bookings()
            ->with(['showtime.movie', 'showtime.hall.cinema', 'payment', 'bookings_seats.seat'])
            ->orderByDesc('id')
            ->get();

        // Upcoming confirmed/pending bookings
        $bookedMovies = $bookings->filter(function ($b) {
            return $b->status !== 'canceled'
                && $b->showtime
                && $b->showtime->end_time
                && $b->showtime->end_time->greaterThan(Carbon::now());
        })->values();

        // Past watched movies (showtime ended + payment paid)
        $watchedMovies = $bookings->filter(function ($b) {
            return $b->status !== 'canceled'
                && optional($b->payment)->status === 'paid'
                && $b->showtime
                && $b->showtime->end_time
                && $b->showtime->end_time->lte(Carbon::now());
        })->values();

        // User's reviews
        $reviews = Reviews::with('movie')
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        return view('profile.show', compact('user', 'bookedMovies', 'watchedMovies', 'reviews'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'                  => 'required|string|max:100',
            'email'                 => "required|email|unique:users,email,{$user->id}",
            'current_password'      => 'nullable|string',
            'password'              => 'nullable|min:6|confirmed',
        ]);

        // Verify current password if trying to change password
        if ($request->filled('password')) {
            if (!$request->filled('current_password') || !Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
            }
            $user->password = Hash::make($validated['password']);
        }

        $user->name  = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $user = Auth::user();

        // Delete old avatar
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $path;
        $user->save();

        return back()->with('success', 'Profile picture updated.');
    }
}
