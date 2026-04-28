<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book Seats - CineMax</title>
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

        .page-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2.5rem;
            color: var(--accent);
            text-align: center;
            margin-bottom: 2rem;
            letter-spacing: 1px;
        }

        .booking-details {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 0.75rem;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .seats-grid {
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 0.5rem;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .seat-checkbox {
            position: relative;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 4.8rem;
            min-height: 4.8rem;
            padding: 0.75rem;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 0.75rem;
            cursor: pointer;
            transition: background 0.2s, border-color 0.2s, transform 0.15s;
        }

        .seat-checkbox:hover {
            transform: translateY(-1px);
            border-color: rgba(232, 52, 10, 0.35);
        }

        .seat-checkbox input {
            display: none;
        }

        .seat-checkbox label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            cursor: pointer;
            color: var(--text);
            font-weight: 700;
            font-size: 0.95rem;
            text-transform: uppercase;
        }

        .seat-checkbox input:checked + label {
            background: var(--accent);
            border-radius: 0.5rem;
            color: var(--bg);
            box-shadow: 0 0 0 2px rgba(232, 52, 10, 0.18);
        }

        .seat-checkbox input:disabled + label {
            color: var(--muted);
            cursor: not-allowed;
        }

        .seat-checkbox input:disabled {
            opacity: 0.85;
        }

        .seat-checkbox.booked {
            background: rgba(255, 107, 107, 0.08);
            border-color: rgba(255, 107, 107, 0.25);
            cursor: not-allowed;
        }

        .seat-checkbox.booked:hover {
            transform: none;
        }

        .seat-checkbox.booked label {
            color: #ff9ea1;
            cursor: not-allowed;
        }

        .seat-checkbox.booked::after {
            content: '✕';
            position: absolute;
            right: 0.6rem;
            top: 0.6rem;
            color: #ff6b6b;
            font-weight: bold;
            font-size: 0.85rem;
        }

        .seat-map {
            display: flex;
            flex-direction: column;
            gap: 1.15rem;
        }

        .screen-banner {
            margin: 0 auto;
            max-width: 680px;
            width: calc(100% - 1rem);
            text-align: center;
            padding: 0.8rem 1rem;
            border-radius: 999px;
            background: linear-gradient(90deg, rgba(232, 52, 10, 0.16), rgba(232, 52, 10, 0.05));
            color: var(--text);
            font-weight: 700;
            letter-spacing: 1px;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .seat-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.85rem;
            align-items: center;
        }

        .row-label {
            min-width: 2.6rem;
            text-align: center;
            color: var(--muted);
            font-size: 0.95rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .seat-row-items {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.85rem;
        }

        .seat-map-note {
            color: var(--muted);
            font-size: 0.95rem;
            margin-top: 0.5rem;
        }

        .btn-book {
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

        .btn-book:hover {
            background: #c42908;
            transform: translateY(-2px);
            color: white;
        }

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
        <h1 class="page-title">BOOK SEATS</h1>

        @if ($errors->has('seats'))
            <div style="background: rgba(255, 107, 107, 0.1); border: 1px solid rgba(255, 107, 107, 0.3); color: #ff6b6b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 2rem;">
                <i class="bi bi-exclamation-triangle"></i> {{ $errors->first('seats') }}
            </div>
        @endif

        <div class="booking-details">
            <h3>{{ $showtime->movie->title }}</h3>
            <p><strong>Showtime:</strong> {{ $showtime->start_time->format('M j, Y g:i A') }}</p>
            <p><strong>Hall:</strong> {{ $showtime->hall->name }} at {{ $showtime->hall->cinema->name }}</p>
            <p><strong>Price per seat:</strong> ₱{{ number_format($showtime->price, 0) }}</p>
        </div>

        <form method="POST" action="{{ route('bookings.store') }}">
            @csrf
            <input type="hidden" name="showtime_id" value="{{ $showtime->id }}">
            <div class="seats-grid">
                <h3>Select Seats</h3>
                <div class="seat-map-note">Screen is at the top. Choose seats based on the row label and how close you want to be.</div>
                <div class="seat-map">
                    <div class="screen-banner">BIG SCREEN</div>
                    @php
                        $rows = $seats->sortBy('number')->groupBy('row_number');
                    @endphp
                    @foreach($rows as $rowLabel => $rowSeats)
                        <div class="seat-row">
                            <div class="row-label">Row {{ $rowLabel }}</div>
                            <div class="seat-row-items">
                                @foreach($rowSeats as $seat)
                                    @php
                                        $isBooked = in_array($seat->id, $bookedSeatIds);
                                    @endphp
                                    <div class="seat-checkbox {{ $isBooked ? 'booked' : '' }}">
                                        <input class="form-check-input" type="checkbox" name="seats[]" value="{{ $seat->id }}" id="seat{{ $seat->id }}" {{ $isBooked ? 'disabled' : '' }}>
                                        <label class="form-check-label" for="seat{{ $seat->id }}" title="{{ $isBooked ? 'This seat is already booked' : 'Select seat ' . $seat->row_number . $seat->number }}">
                                            {{ $seat->row_number }}{{ $seat->number }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn-book">Book Selected Seats</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>