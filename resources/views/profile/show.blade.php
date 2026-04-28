<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Profile - CineMax</title>
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
            --muted: rgba(240,239,244,0.6);
            --border: rgba(240,239,244,0.1);
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
        }

        .navbar {
            background: rgba(13,13,15,0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
        }

        .navbar-brand {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.8rem;
            color: var(--accent) !important;
            letter-spacing: 2px;
        }

        .profile-card, .section-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 0.9rem;
            padding: 1.25rem;
        }

        .section-title {
            font-family: 'Bebas Neue', sans-serif;
            letter-spacing: 1px;
            color: var(--accent);
            margin-bottom: 1rem;
        }

        .movie-item {
            border: 1px solid var(--border);
            border-radius: 0.75rem;
            padding: 0.9rem;
            background: var(--surface2);
            margin-bottom: 0.75rem;
        }

        .meta {
            color: var(--muted);
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid px-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <a class="navbar-brand" href="/">
                    <i class="bi bi-play-circle-fill"></i> CINEMAX
                </a>
                <a class="nav-link text-light" href="/">Home</a>
                <a class="nav-link text-light" href="{{ route('cinemas.index') }}">Cinema</a>
                <div class="dropdown">
                    <a class="nav-link text-light dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Movies
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="{{ route('movies.index', ['status' => 'now-showing']) }}">Now Showing</a></li>
                        <li><a class="dropdown-item" href="{{ route('movies.index', ['status' => 'coming-soon']) }}">Coming Soon</a></li>
                        <li><a class="dropdown-item" href="{{ route('movies.index') }}">All Movies</a></li>
                    </ul>
                </div>
                <a class="nav-link text-light" href="{{ route('bookings.index') }}">My Bookings</a>
            </div>
            <div class="d-flex align-items-center">
                @include('partials.user-menu')
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="profile-card mb-4">
            <h1 class="section-title">My Profile</h1>
            <div><strong>Name:</strong> {{ $user->name }}</div>
            <div><strong>Email:</strong> {{ $user->email }}</div>
            <div><strong>Status:</strong> {{ ucfirst($user->status ?? 'active') }}</div>
        </div>

        <div class="section-card mb-4">
            <h2 class="section-title">Booked Movies</h2>
            @forelse($bookedMovies as $booking)
                <div class="movie-item">
                    <div><strong>{{ $booking->showtime->movie->title ?? 'Unknown Movie' }}</strong></div>
                    <div class="meta">
                        Showtime: {{ optional($booking->showtime->start_time)->format('M d, Y h:i A') }} |
                        Cinema: {{ $booking->showtime->hall->cinema->name ?? 'N/A' }} |
                        Status: {{ ucfirst($booking->status) }}
                    </div>
                </div>
            @empty
                <p class="meta mb-0">No upcoming booked movies yet.</p>
            @endforelse
        </div>

        <div class="section-card">
            <h2 class="section-title">Watched Movies</h2>
            @forelse($watchedMovies as $booking)
                <div class="movie-item">
                    <div><strong>{{ $booking->showtime->movie->title ?? 'Unknown Movie' }}</strong></div>
                    <div class="meta">
                        Watched on: {{ optional($booking->showtime->start_time)->format('M d, Y h:i A') }} |
                        Cinema: {{ $booking->showtime->hall->cinema->name ?? 'N/A' }}
                    </div>
                </div>
            @empty
                <p class="meta mb-0">No watched movies yet.</p>
            @endforelse
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
