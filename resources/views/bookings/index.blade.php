<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Bookings - CineMax</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,300&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg:       #0d0d0f;
            --surface:  #141417;
            --surface2: #1c1c21;
            --accent:   #e8340a;
            --accent2:  #ff6b35;
            --text:     #f0eff4;
            --muted:    rgba(240,239,244,0.6);
            --border:   rgba(240,239,244,0.1);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background: var(--bg); color: var(--text); font-family: 'DM Sans', sans-serif; min-height: 100vh; }
        .navbar { background: rgba(13,13,15,0.95); backdrop-filter: blur(18px); -webkit-backdrop-filter: blur(18px); border-bottom: 1px solid var(--border); padding: 0.9rem 0; position: sticky; top: 0; z-index: 100; }
        .navbar-brand { font-family: 'Bebas Neue', sans-serif; font-size: 1.8rem; color: var(--accent) !important; letter-spacing: 2px; display: flex; align-items: center; gap: 0.4rem; text-decoration: none; }
        .navbar-brand .brand-dot { width: 8px; height: 8px; background: var(--accent); border-radius: 50%; display: inline-block; animation: pulse-dot 2s ease-in-out infinite; }
        @keyframes pulse-dot { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.4; transform: scale(0.7); } }
        .nav-link { color: var(--muted) !important; font-size: 0.88rem; font-weight: 500; letter-spacing: 0.5px; padding: 0.4rem 1rem !important; transition: color 0.2s; }
        .nav-link:hover { color: var(--text) !important; }
        .search-wrap {
            position: relative;
            display: inline-flex;
            align-items: center;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 999px;
            padding: 0.35rem 0.9rem;
            min-width: 240px;
        }

        .search-wrap .bi-search {
            color: var(--muted);
            margin-right: 0.5rem;
            font-size: 1rem;
        }

        .search-wrap input {
            background: transparent;
            border: none;
            outline: none;
            color: var(--text);
            width: 180px;
            min-width: 120px;
        }

        .search-wrap input::placeholder {
            color: var(--muted);
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .navbar-text.welcome-text {
            font-family: 'Bebas Neue', sans-serif;
            letter-spacing: 0.8px;
            color: var(--text) !important;
        }

        .container { padding: 2rem; }
        .page-title { font-family: 'Bebas Neue', sans-serif; font-size: 2.5rem; color: var(--accent); margin-bottom: 1.5rem; }
        .booking-card { background: var(--surface); border: 1px solid var(--border); border-radius: 0.85rem; padding: 1.75rem; margin-bottom: 1.5rem; }
        .booking-card h2 { font-size: 1.6rem; margin-bottom: 1rem; }
        .booking-meta { display: flex; flex-wrap: wrap; gap: 1rem; font-size: 0.95rem; color: var(--muted); margin-bottom: 1rem; }
        .booking-meta span { display: inline-flex; align-items: center; gap: 0.4rem; }
        .tag { display: inline-block; padding: 0.3rem 0.65rem; border-radius: 999px; background: rgba(232,52,10,0.15); color: var(--accent); font-weight: 600; font-size: 0.85rem; }
        .seat-list { margin-bottom: 1rem; }
        .seat-chip { display: inline-block; margin: 0 0.25rem 0.25rem 0; padding: 0.4rem 0.7rem; border-radius: 999px; background: rgba(240,239,244,0.08); color: var(--text); border: 1px solid rgba(240,239,244,0.08); }
        .btn-action { background: var(--accent); color: white; border: none; padding: 0.65rem 1.1rem; border-radius: 0.5rem; font-weight: 600; text-decoration: none; transition: background 0.2s; }
        .btn-action:hover { background: #c42908; }
        .badge-pending   { color: #ffcb6b; }
        .badge-confirmed { color: #4add8a; }
        .badge-canceled  { color: #ff6b6b; }
        .badge-finished  {
            background: rgba(255,255,255,0.06);
            color: rgba(240,239,244,0.45);
            border: 1px solid rgba(255,255,255,0.08);
        }
        .booking-card.is-finished {
            opacity: 0.72;
            border-color: rgba(240,239,244,0.05);
        }
        .booking-card.is-finished h2 { color: var(--muted); }
        .alert { background: rgba(232,52,10,0.1); border: 1px solid rgba(232,52,10,0.3); color: var(--accent); border-radius: 0.5rem; padding: 0.9rem 1rem; margin-bottom: 1.5rem; }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="container-fluid px-4 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <a class="navbar-brand" href="/">
                <i class="bi bi-play-circle-fill"></i>
                CINEMAX
                <span class="brand-dot"></span>
            </a>
            <a class="nav-link" href="/">Home</a>
            <a class="nav-link" href="{{ route('cinemas.index') }}">Cinema</a>
            <div class="dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Movies
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('movies.index', ['status' => 'now-showing']) }}">Now Showing</a></li>
                    <li><a class="dropdown-item" href="{{ route('movies.index', ['status' => 'coming-soon']) }}">Coming Soon</a></li>
                </ul>
            </div>
            <a class="nav-link" href="{{ route('bookings.index') }}">My Bookings</a>
        </div>
        <div class="navbar-user">
            @include('partials.user-menu')
        </div>
    </div>
</nav>

<div class="container">
    <h1 class="page-title">My Bookings</h1>
    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif
    @if($bookings->isEmpty())
        <div class="booking-card">
            <p>You have no bookings yet. Browse movies to make your first reservation.</p>
            <a href="/movies" class="btn-action">Browse Movies</a>
        </div>
    @else
        @foreach($bookings as $booking)
            @php
            $isFinished = $booking->showtime->end_time->isPast();
        @endphp
        <div class="booking-card {{ $isFinished ? 'is-finished' : '' }}">
                <h2>{{ $booking->showtime->movie->title }}</h2>
                <div class="booking-meta">
                    <span><i class="bi bi-calendar-event"></i> {{ $booking->showtime->start_time->format('M j, Y g:i A') }}</span>
                    <span><i class="bi bi-building"></i> {{ $booking->showtime->hall->cinema->name }} - {{ $booking->showtime->hall->name }}</span>

                    {{-- Status badge --}}
                    @if($isFinished && $booking->status === 'confirmed')
                        <span class="tag badge-finished">
                            <i class="bi bi-film"></i> Movie Finished
                        </span>
                    @else
                        <span class="tag {{ $booking->status === 'confirmed' ? 'badge-confirmed' : ($booking->status === 'canceled' ? 'badge-canceled' : 'badge-pending') }}">
                            {{ strtoupper($booking->status) }}
                        </span>
                    @endif

                    <span class="tag {{ $booking->payment->status === 'pending' ? 'badge-pending' : ($booking->payment->status === 'canceled' ? 'badge-canceled' : 'badge-confirmed') }}">Payment: {{ ucfirst($booking->payment->status) }}</span>
                    @if($booking->tickets->isNotEmpty())
                        <span class="tag badge-confirmed"><i class="bi bi-ticket-perforated"></i> {{ $booking->tickets->count() }} Ticket{{ $booking->tickets->count() === 1 ? '' : 's' }}</span>
                    @endif
                </div>
                <div class="seat-list">
                    @foreach($booking->bookings_seats as $seat)
                        <span class="seat-chip">{{ $seat->seat->row_number }}{{ $seat->seat->number }}</span>
                    @endforeach
                </div>
                <div class="d-flex gap-3 flex-wrap align-items-center">
                    <span class="tag">Total: ₱{{ number_format($booking->payment->amount, 0) }}</span>
                    <a href="{{ route('bookings.show', $booking) }}" class="btn-action">View Details</a>
                    @if(!$isFinished)
                        @if($booking->payment->status === 'pending')
                            <form method="POST" action="{{ route('bookings.pay', $booking) }}">
                                @csrf
                                <button type="submit" class="btn-action">Pay Now</button>
                            </form>
                            <form method="POST" action="{{ route('bookings.cancel', $booking) }}">
                                @csrf
                                <button type="submit" class="btn-action" style="background: #444;">Cancel Booking</button>
                            </form>
                        @elseif($booking->status !== 'canceled')
                            <form method="POST" action="{{ route('bookings.cancel', $booking) }}">
                                @csrf
                                <button type="submit" class="btn-action" style="background: #444;">Cancel Booking</button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        @endforeach
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>