<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Movies - CineMax</title>
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
        .nav-link.dropdown-toggle::after {
            margin-left: 0.4rem;
            vertical-align: 0.15em;
        }
        .dropdown-menu {
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 0.5rem;
        }
        .dropdown-item {
            color: var(--muted);
            font-size: 0.88rem;
        }
        .dropdown-item:hover,
        .dropdown-item:focus,
        .dropdown-item.active {
            color: var(--text);
            background: rgba(232,52,10,0.2);
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

        .movie-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 0.75rem;
            overflow: hidden;
            transition: transform 0.25s, border-color 0.25s, box-shadow 0.25s;
            cursor: pointer;
            position: relative;
            display: flex;
            flex-direction: column;
            min-height: 100%;
            margin: 0;
        }

        .movie-card:hover {
            transform: translateY(-6px);
            border-color: rgba(232,52,10,0.4);
            box-shadow: 0 20px 50px rgba(0,0,0,0.5), 0 0 0 1px rgba(232,52,10,0.2);
        }

        .card-body {
            padding: 1rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .card-title {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            color: var(--text);
        }

        .card-text {
            color: var(--muted);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .btn-book {
            background: var(--accent);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.4rem;
            font-family: 'DM Sans', sans-serif;
            font-weight: 600;
            font-size: 0.85rem;
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

        .btn-book {
            margin-top: auto;
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
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('movies.index') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Movies
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item {{ request('status') === 'now-showing' ? 'active' : '' }}" href="{{ route('movies.index', ['status' => 'now-showing']) }}">Now Showing</a></li>
                        <li><a class="dropdown-item {{ request('status') === 'coming-soon' ? 'active' : '' }}" href="{{ route('movies.index', ['status' => 'coming-soon']) }}">Coming Soon</a></li>
                    </ul>
                </div>
                @if(Auth::check())
                    <a class="nav-link" href="{{ route('bookings.index') }}">My Bookings</a>
                @endif
            </div>

            <div class="navbar-user">
                @include('partials.user-menu')
            </div>
        </div>
    </nav>

    <div class="container">
        @if(request('status') === 'now-showing')
            <h1 class="page-title">NOW SHOWING</h1>
        @elseif(request('status') === 'coming-soon')
            <h1 class="page-title">COMING SOON</h1>
        @else
            <h1 class="page-title">MOVIES</h1>
        @endif
        <div class="row g-4">
            @foreach($movies as $movie)
                <div class="col-md-4 col-sm-6 d-flex">
                    <div class="movie-card">
                        <div class="card-poster" style='background-image: url("{{ $movie->poster_url }}"); background-size: cover; background-position: center; height: 300px; border-radius: 0.5rem 0.5rem 0 0;'></div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $movie->title }}</h5>
                            <p class="card-text">{{ Str::limit($movie->description, 100) }}</p>
                            <p class="card-text">Genre: {{ $movie->genre->name ?? 'N/A' }}</p>
                            <p class="card-text">Duration: {{ $movie->duration }} min</p>
                            <p class="card-text">Show Time: {{ $movie->showtime ? $movie->showtime->start_time->format('M d, Y H:i') : 'N/A' }}</p>
                            @if($movie->reviews_count)
                                <p class="card-text">
                                    <span class="text-warning">
                                        @for($star = 1; $star <= 5; $star++)
                                            <i class="bi bi-star-fill" style="opacity: {{ $star <= round($movie->reviews_avg_rating) ? '1' : '0.25' }}"></i>
                                        @endfor
                                    </span>
                                    {{ number_format($movie->reviews_avg_rating, 1) }} / 5 ({{ $movie->reviews_count }})
                                </p>
                            @else
                                <p class="card-text">No reviews yet</p>
                            @endif
                            <a href="{{ route('movies.show', $movie) }}" class="btn-book">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>