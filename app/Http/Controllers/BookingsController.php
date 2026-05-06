<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Bookings_seats;
use App\Models\Payments;
use App\Models\Tickets;
use App\Models\Showtimes;
use App\Services\PayMongoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookingsController extends Controller
{
    private PayMongoService $payMongo;

    public function __construct()
    {
        $this->payMongo = new PayMongoService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Bookings::with('showtime.movie', 'showtime.hall.cinema', 'bookings_seats.seat', 'payment', 'tickets')
            ->where('user_id', auth()->id())
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    public function create(Request $request)
    {
        $showtimeId = $request->query('showtime');
        $showtime = \App\Models\Showtimes::with('hall.seats', 'movie')->findOrFail($showtimeId);

        // Redirect immediately if the showtime has already ended
        if ($showtime->end_time <= now()) {
            return redirect()->route('movies.show', $showtime->movie_id)
                ->with('error', 'Sorry, this screening has already ended. Please choose an upcoming showtime.');
        }

        $seats = $showtime->hall->seats;

        // Get already booked seats for this showtime.
        // Only count seats as booked if the showtime has NOT ended yet.
        // Once end_time passes the movie is over and all seats reset automatically.
        $bookedSeatIds = Bookings_seats::whereHas('booking', function ($query) use ($showtimeId) {
            $query->where('showtime_id', $showtimeId)
                ->whereHas('payment', function ($paymentQuery) {
                    $paymentQuery->where('status', 'paid');
                })
                ->whereHas('showtime', function ($showtimeQuery) {
                    // Only treat as booked if the showtime is still ongoing or in the future
                    $showtimeQuery->where('end_time', '>', now());
                });
        })->pluck('seat_id')->toArray();

        return view('bookings.create', compact('showtime', 'seats', 'bookedSeatIds'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'seats' => 'required|array|min:1',
            'seats.*' => 'exists:seats,id',
        ]);

        $showtime = Showtimes::findOrFail($request->showtime_id);

        // ── Ended showtime guard ─────────────────────────────────────────────────────
        // Prevent booking a showtime that has already finished.
        if ($showtime->end_time <= now()) {
            return back()->withErrors([
                'showtime_id' => 'This screening has already ended. Please choose an upcoming showtime.'
            ]);
        }
        // ── End ended showtime guard ─────────────────────────────────────────────────

        // ── Overlap check ────────────────────────────────────────────────────────────
        // Prevent booking a showtime that overlaps another one already running
        // in the same hall at the same time.
        $overlap = Showtimes::where('hall_id', $showtime->hall_id)
            ->where('id', '!=', $showtime->id)
            ->where('start_time', '<', $showtime->end_time)
            ->where('end_time',   '>', $showtime->start_time)
            ->exists();

        if ($overlap) {
            return back()->withErrors([
                'showtime_id' => 'This screening overlaps another scheduled movie in the same hall. Please choose a different showtime.'
            ]);
        }
        // ── End overlap check ────────────────────────────────────────────────────────

        // Check if any selected seats are already booked for this showtime.
        // Only count seats as booked if the showtime has NOT ended yet
        // (mirrors the same filter in create() so visuals match validation).
        $bookedSeats = Bookings_seats::whereIn('seat_id', $request->seats)
            ->whereHas('booking', function ($query) use ($request) {
                $query->where('showtime_id', $request->showtime_id)
                    ->whereHas('payment', function ($paymentQuery) {
                        $paymentQuery->where('status', 'paid');
                    })
                    ->whereHas('showtime', function ($showtimeQuery) {
                        $showtimeQuery->where('end_time', '>', now());
                    });
            })
            ->with('seat')
            ->get();

        if ($bookedSeats->isNotEmpty()) {
            $seatNumbers = $bookedSeats->map(fn($bs) => $bs->seat->row_number . $bs->seat->number)->implode(', ');
            return back()->withErrors(['seats' => "The following seats are already booked: $seatNumbers. Please select different seats."]);
        }

        $booking = Bookings::create([
            'user_id' => auth()->id(),
            'showtime_id' => $request->showtime_id,
            'date' => now(),
            'status' => 'pending',
        ]);

        $totalPrice = 0;
        foreach ($request->seats as $seatId) {
            Bookings_seats::create([
                'booking_id' => $booking->id,
                'seat_id' => $seatId,
            ]);
            $totalPrice += $showtime->price;
        }

        $booking->payment()->create([
            'amount' => $totalPrice,
            'method' => 'online',
            'status' => 'pending',
            'date' => now(),
        ]);

        return redirect()->route('bookings.show', $booking);
    }

    public function show(Bookings $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->load('showtime.movie', 'showtime.hall.cinema', 'bookings_seats.seat', 'payment', 'tickets.seat');
        return view('bookings.show', compact('booking'));
    }

    public function pay(Request $request, Bookings $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->load('payment', 'bookings_seats', 'showtime.movie');

        if (!$booking->payment) {
            return back()->with('error', 'Payment record not found.');
        }

        if ($booking->payment->status !== 'pending') {
            return back()->with('info', 'This booking is already paid.');
        }

        // Create PayMongo checkout session
        $user = auth()->user();
        
        // Use the current request to build the success/cancel URLs to ensure they match the environment
        $successUrl = route('bookings.payment-success', ['booking' => $booking->id]) . '?session={CHECKOUT_SESSION_ID}';
        $cancelUrl = route('bookings.show', ['booking' => $booking->id]);

        $checkoutData = [
            'product_name' => 'Cinema Ticket',
            'product_description' => 'Movie: ' . $booking->showtime->movie->title,
            'quantity' => 1,
            'amount' => (float)$booking->payment->amount,
            'reference_number' => 'B' . $booking->id . '-' . time(),
            'description' => 'Cinema Booking #' . $booking->id,
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
        ];

        $response = $this->payMongo->createCheckoutSession($checkoutData);

        if (!$response['success']) {
            return back()->with('error', 'Failed to initiate payment: ' . $response['error']);
        }

        // Store session ID in payment
        $booking->payment->update([
            'paymongo_session_id' => $response['data']['id'],
        ]);

        // Redirect to PayMongo checkout
        return redirect()->away($response['data']['attributes']['checkout_url']);
    }

    public function paymentSuccess(Request $request, Bookings $booking)
    {
        Log::info('paymentSuccess method called', [
            'booking_id' => $booking->id,
            'query'      => $request->all()
        ]);

        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->load('payment', 'bookings_seats', 'tickets.seat');

        if (!$booking->payment) {
            return redirect()->route('bookings.show', $booking)->with('error', 'Payment record not found.');
        }

        // Already confirmed — just show the booking
        if ($booking->status === 'confirmed') {
            return redirect()->route('bookings.show', $booking)->with('success', 'Your booking is confirmed!');
        }

        // Determine which session ID to verify:
        // 1. Use the one stored in the DB (most reliable)
        // 2. Fall back to URL param
        $sessionId = $booking->payment->paymongo_session_id ?? $request->query('session');

        if (!$sessionId) {
            return redirect()->route('bookings.show', $booking)->with('error', 'Payment session not found.');
        }

        // Retrieve session from PayMongo to verify actual payment status
        $response = $this->payMongo->retrieveCheckoutSession($sessionId);

        if (!$response['success']) {
            // PayMongo API call failed — mark as confirmed optimistically if
            // the user arrived on the success URL (PayMongo only redirects here on success)
            Log::warning('Could not verify PayMongo session, confirming optimistically', [
                'booking_id' => $booking->id,
                'session_id' => $sessionId,
            ]);

            $booking->payment->update([
                'status' => 'paid',
                'method' => 'paymongo',
                'date'   => now(),
            ]);
            $booking->update(['status' => 'confirmed']);

            foreach ($booking->bookings_seats as $bookedSeat) {
                $ticketCode = 'TIX-' . strtoupper(substr(md5(uniqid() . $booking->id), 0, 8));
                Tickets::firstOrCreate(
                    ['booking_id' => $booking->id, 'seat_id' => $bookedSeat->seat_id],
                    ['code' => $ticketCode, 'issued_at' => now()]
                );
            }

            $booking->load('tickets.seat');
            return redirect()->route('bookings.show', $booking)->with('success', 'Payment successful! Your tickets have been generated.');
        }

        $sessionData   = $response['data'];
        $sessionStatus = $sessionData['attributes']['status'] ?? null;

        Log::info('PayMongo session status', [
            'booking_id'     => $booking->id,
            'session_id'     => $sessionId,
            'session_status' => $sessionStatus,
        ]);

        if ($sessionStatus === 'paid' || $sessionStatus === 'active') {
            // Update payment record
            $booking->payment->update([
                'status'              => 'paid',
                'method'              => 'paymongo',
                'paymongo_session_id' => $sessionId,
                'paymongo_payment_id' => $sessionData['attributes']['payments'][0]['id'] ?? null,
                'date'                => now(),
            ]);

            // Confirm booking
            $booking->update(['status' => 'confirmed']);

            // Generate tickets
            foreach ($booking->bookings_seats as $bookedSeat) {
                $ticketCode = 'TIX-' . strtoupper(substr(md5(uniqid() . $booking->id), 0, 8));
                Tickets::firstOrCreate(
                    ['booking_id' => $booking->id, 'seat_id' => $bookedSeat->seat_id],
                    ['code' => $ticketCode, 'issued_at' => now()]
                );
            }

            $booking->load('tickets.seat');
            return redirect()->route('bookings.show', $booking)->with('success', 'Payment successful! Your tickets have been generated.');
        }

        return redirect()->route('bookings.show', $booking)
            ->with('error', 'Payment was not completed. Status: ' . ($sessionStatus ?? 'unknown'));
    }

    public function cancel(Request $request, Bookings $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->status === 'canceled') {
            return back()->with('info', 'This booking has already been canceled.');
        }

        $booking->update(['status' => 'canceled']);

        if ($booking->payment) {
            $booking->payment->update(['status' => 'canceled']);
        }

        return back()->with('success', 'Your booking has been canceled.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bookings $bookings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bookings $bookings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bookings $bookings)
    {
        //
    }
}
