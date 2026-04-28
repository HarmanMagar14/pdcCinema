<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Confirmation - CineMax</title>
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
            --gold:     #f5c518;
            --text:     #f0eff4;
            --muted:    rgba(240,239,244,0.5);
            --border:   rgba(240,239,244,0.08);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
        }

        .navbar {
            background: rgba(13,13,15,0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: 0.9rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-brand {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.8rem;
            color: var(--accent) !important;
            letter-spacing: 2px;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            text-decoration: none;
        }

        .navbar-brand .brand-dot {
            width: 8px;
            height: 8px;
            background: var(--accent);
            border-radius: 50%;
            display: inline-block;
            animation: pulse-dot 2s ease-in-out infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: 0.4; transform: scale(0.7); }
        }

        .nav-link {
            color: var(--muted) !important;
            font-size: 0.88rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            padding: 0.4rem 1rem !important;
            transition: color 0.2s;
        }

        .nav-link:hover { color: var(--text) !important; }

        .container {
            padding: 2rem;
        }

        .confirmation-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 0.75rem;
            padding: 3rem;
            text-align: center;
            max-width: 600px;
            margin: 0 auto;
        }

        .confirmation-icon {
            font-size: 4rem;
            color: var(--accent);
            margin-bottom: 1rem;
        }

        .confirmation-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2.5rem;
            color: var(--accent);
            margin-bottom: 1rem;
            letter-spacing: 1px;
        }

        .booking-details {
            background: var(--surface2);
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            color: var(--text);
        }

        .detail-label {
            font-weight: 600;
            color: var(--muted);
        }

        .btn-home {
            background: var(--accent);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 0.4rem;
            font-family: 'DM Sans', sans-serif;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-home:hover {
            background: #c42908;
            transform: translateY(-2px);
            color: white;
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

        /* ── SEARCH ── */
        .search-wrap { position: relative; }

        .search-wrap input {
            background: var(--surface2);
            border: 1px solid var(--border);
            color: var(--text);
            border-radius: 2rem;
            padding: 0.5rem 1rem 0.5rem 2.4rem;
            font-size: 0.85rem;
            width: 220px;
            transition: border-color 0.2s, width 0.3s;
        }

        .search-wrap input:focus {
            outline: none;
            border-color: rgba(232,52,10,0.5);
            width: 260px;
            background: var(--surface2);
            color: var(--text);
            box-shadow: none;
        }

        .search-wrap input::placeholder { color: var(--muted); }

        .search-wrap .bi-search {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 0.8rem;
        }

        /* ── DROPDOWN ── */
        .dropdown-menu {
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 0.5rem;
        }
        .dropdown-item { color: var(--muted); font-size: 0.88rem; }
        .dropdown-item:hover { color: var(--text); background: rgba(232,52,10,0.2); }
    </style>
</head>
<body>

    <!-- NAVBAR -->
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
                        <li><a class="dropdown-item" href="{{ route('movies.index') }}">All Movies</a></li>
                    </ul>
                </div>
                @if(Auth::check())
                    <a class="nav-link" href="{{ route('bookings.index') }}">My Bookings</a>
                @endif
            </div>

            <form method="GET" action="{{ route('movies.index') }}" class="search-wrap d-flex align-items-center">
                <i class="bi bi-search"></i>
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Search movies, genres…">
            </form>

            <div class="navbar-user">
                @include('partials.user-menu')
            </div>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="background: rgba(40, 167, 69, 0.2); border: 1px solid #28a745; color: #fff;">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="background: rgba(220, 53, 69, 0.2); border: 1px solid #dc3545; color: #fff;">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show mb-4" role="alert" style="background: rgba(23, 162, 184, 0.2); border: 1px solid #17a2b8; color: #fff;">
                <i class="bi bi-info-circle-fill me-2"></i> {{ session('info') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @php
        $isCanceled = $booking->status === 'canceled' || optional($booking->payment)->status === 'canceled';
        $isPaid = $booking->status === 'confirmed' || optional($booking->payment)->status === 'paid';
    @endphp
    <div class="confirmation-card">
            <div class="confirmation-icon">
                @if($isCanceled)
                    <i class="bi bi-x-circle-fill" style="color: #dc3545;"></i>
                @elseif($isPaid)
                    <i class="bi bi-check-circle-fill" style="color: #28a745;"></i>
                @else
                    <i class="bi bi-clock-history" style="color: #ffc107;"></i>
                @endif
            </div>
            
            <h1 class="confirmation-title">
                @if($isCanceled)
                    BOOKING CANCELLED
                @elseif($isPaid)
                    BOOKING CONFIRMED
                @else
                    BOOKING PENDING
                @endif
            </h1>
            <div class="booking-details">
                <div class="detail-item">
                    <span class="detail-label">Movie:</span>
                    <span>{{ $booking->showtime->movie->title }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Showtime:</span>
                    <span>{{ $booking->showtime->start_time->format('M j, Y g:i A') }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Seats:</span>
                    <span>@foreach($booking->bookings_seats as $bs) {{ $bs->seat->row_number }}{{ $bs->seat->number }} @endforeach</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Total:</span>
                    <span>₱{{ number_format($booking->payment->amount, 0) }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Status:</span>
                    <span>{{ ucfirst($booking->status) }}</span>
                </div>
            </div>

            @if(!$isCanceled && $booking->tickets->isNotEmpty())
                <div style="background: var(--surface2); border-radius: 0.5rem; padding: 1.5rem; margin-bottom: 2rem;">
                    <h3 style="margin-bottom: 1rem; font-size: 1.2rem;">Your Tickets</h3>
                    @foreach($booking->tickets as $ticket)
                        <div style="background: rgba(232,52,10,0.1); border: 1px solid rgba(232,52,10,0.3); border-radius: 0.5rem; padding: 1rem; margin-bottom: 0.75rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                                <div>
                                    <strong style="color: var(--accent);">Seat {{ $ticket->seat->row_number }}{{ $ticket->seat->number }}</strong>
                                </div>
                                <div style="background: #222; padding: 0.5rem 1rem; border-radius: 0.4rem; font-family: 'Courier New', monospace; font-size: 1.1rem; font-weight: bold; color: var(--gold);">{{ $ticket->code }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @if(!$isCanceled && optional($booking->payment)->status === 'pending')
                <form method="POST" action="{{ route('bookings.pay', $booking) }}" class="mb-3">
                    @csrf
                    <button type="submit" class="btn-home">Pay Now</button>
                </form>
            @endif
            <a href="/" class="btn-home">Back to Home</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>