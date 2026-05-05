<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cinemas - CineMax</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,300&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0d0d0f;
            --surface: #141417;
            --surface2: #1c1c21;
            --accent: #e8340a;
            --text: #f0eff4;
            --muted: rgba(240,239,244,0.5);
            --border: rgba(240,239,244,0.08);
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
            50% { opacity: 0.4; transform: scale(0.7); }
        }
        .nav-link {
            color: var(--muted) !important;
            font-size: 0.88rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            padding: 0.4rem 1rem !important;
        }
        .nav-link:hover,
        .nav-link.active {
            color: var(--text) !important;
        }
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
        .cinema-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 0.75rem;
            padding: 1.25rem;
            margin-bottom: 1rem;
        }
        .cinema-name {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.35rem;
        }
        .cinema-location {
            color: var(--muted);
        }
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
                <a class="nav-link active" href="{{ route('cinemas.index') }}">Cinema</a>
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Movies
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('movies.index', ['status' => 'now-showing']) }}">Now Showing</a></li>
                        <li><a class="dropdown-item" href="{{ route('movies.index', ['status' => 'coming-soon']) }}">Coming Soon</a></li>
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
        <h1 class="page-title">ALL CINEMAS</h1>
        @forelse($cinemas as $cinema)
            <div class="cinema-card">
                <div class="cinema-name">{{ $cinema->name }}</div>
                <div class="cinema-location">{{ $cinema->location }}</div>
            </div>
        @empty
            <p>No cinemas available yet.</p>
        @endforelse
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
