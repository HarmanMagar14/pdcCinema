<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @if(request('status') === 'now-showing') Now Showing
        @elseif(request('status') === 'coming-soon') Coming Soon
        @else Movies
        @endif — CineMax
    </title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg:       #0a0a0c;
            --surface:  #111114;
            --surface2: #18181d;
            --surface3: #1f1f26;
            --accent:   #e8340a;
            --accent2:  #ff6b35;
            --gold:     #f5c518;
            --text:     #f0eff4;
            --muted:    rgba(240,239,244,0.5);
            --border:   rgba(240,239,244,0.07);
            --glow:     rgba(232,52,10,0.35);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ── NAVBAR ─────────────────────────────────────────────────────── */
        .navbar {
            background: rgba(10,10,12,0.88);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-bottom: 1px solid var(--border);
            padding: 0.85rem 0;
            position: sticky;
            top: 0;
            z-index: 200;
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
        .brand-dot {
            width: 8px; height: 8px;
            background: var(--accent);
            border-radius: 50%;
            animation: pulse-dot 2s ease-in-out infinite;
        }
        @keyframes pulse-dot {
            0%,100% { opacity:1; transform:scale(1); }
            50%      { opacity:0.4; transform:scale(0.7); }
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
        .dropdown-menu {
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 0.6rem;
            padding: 0.35rem;
        }
        .dropdown-item {
            color: var(--muted);
            font-size: 0.88rem;
            border-radius: 0.4rem;
            padding: 0.5rem 0.9rem;
        }
        .dropdown-item:hover, .dropdown-item.active {
            color: var(--text);
            background: rgba(232,52,10,0.18);
        }

        /* ── HERO HEADER ─────────────────────────────────────────────────── */
        .page-hero {
            position: relative;
            padding: 4rem 2rem 3.5rem;
            text-align: center;
            overflow: hidden;
        }
        .page-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 70% 60% at 50% -10%, rgba(232,52,10,0.22) 0%, transparent 70%);
            pointer-events: none;
        }
        .page-hero .film-strip {
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 6px;
            background: repeating-linear-gradient(
                90deg,
                var(--accent) 0, var(--accent) 28px,
                transparent 28px, transparent 38px
            );
            opacity: 0.6;
        }
        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(232,52,10,0.12);
            border: 1px solid rgba(232,52,10,0.3);
            border-radius: 999px;
            padding: 0.3rem 1rem;
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--accent2);
            margin-bottom: 1rem;
        }
        .hero-eyebrow .live-dot {
            width: 7px; height: 7px;
            background: var(--accent);
            border-radius: 50%;
            animation: pulse-dot 1.5s ease-in-out infinite;
        }
        .hero-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(3rem, 8vw, 5.5rem);
            letter-spacing: 3px;
            line-height: 1;
            background: linear-gradient(135deg, #fff 30%, rgba(255,255,255,0.55));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.75rem;
        }
        .hero-title span { color: var(--accent); -webkit-text-fill-color: var(--accent); }
        .hero-subtitle {
            color: var(--muted);
            font-size: 1rem;
            max-width: 440px;
            margin: 0 auto 1.8rem;
        }

        /* ── SEARCH & FILTER BAR ─────────────────────────────────────────── */
        .filter-bar {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            flex-wrap: wrap;
            padding: 0 2rem 2.5rem;
        }
        .search-wrap {
            display: flex;
            align-items: center;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.09);
            border-radius: 999px;
            padding: 0.45rem 1rem;
            gap: 0.5rem;
            min-width: 260px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .search-wrap:focus-within {
            border-color: rgba(232,52,10,0.5);
            box-shadow: 0 0 0 3px rgba(232,52,10,0.1);
        }
        .search-wrap i { color: var(--muted); }
        .search-wrap input {
            background: transparent;
            border: none;
            outline: none;
            color: var(--text);
            font-size: 0.9rem;
            width: 200px;
        }
        .search-wrap input::placeholder { color: var(--muted); }
        .filter-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.45rem 1.1rem;
            border-radius: 999px;
            font-size: 0.82rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            border: 1px solid var(--border);
            color: var(--muted);
            background: transparent;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }
        .filter-pill:hover, .filter-pill.active {
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
            box-shadow: 0 4px 20px rgba(232,52,10,0.4);
        }
        .filter-pill.active-soft {
            background: rgba(232,52,10,0.14);
            border-color: rgba(232,52,10,0.4);
            color: var(--accent2);
        }

        /* ── MOVIE GRID ──────────────────────────────────────────────────── */
        .movies-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1.5rem;
            padding: 0 2rem 4rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* ── MOVIE CARD ──────────────────────────────────────────────────── */
        .movie-card {
            position: relative;
            border-radius: 1rem;
            overflow: hidden;
            aspect-ratio: 2/3;
            background: var(--surface2);
            cursor: pointer;
            transition: transform 0.35s cubic-bezier(.22,.68,0,1.2), box-shadow 0.35s;
        }
        .movie-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 30px 70px rgba(0,0,0,0.7), 0 0 0 1px rgba(232,52,10,0.35), 0 0 40px rgba(232,52,10,0.12);
            z-index: 10;
        }

        /* Poster image */
        .card-poster {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            transition: transform 0.5s ease;
        }
        .movie-card:hover .card-poster {
            transform: scale(1.08);
        }

        /* Permanent bottom gradient */
        .card-gradient {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to top,
                rgba(8,8,10,0.98) 0%,
                rgba(8,8,10,0.7)  35%,
                rgba(8,8,10,0.1)  65%,
                transparent       100%
            );
            transition: opacity 0.3s;
        }

        /* Hover overlay */
        .card-hover-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to top,
                rgba(8,8,10,0.99) 0%,
                rgba(8,8,10,0.88) 55%,
                rgba(8,8,10,0.4)  100%
            );
            opacity: 0;
            transition: opacity 0.3s;
        }
        .movie-card:hover .card-hover-overlay { opacity: 1; }

        /* Status badge */
        .card-badge {
            position: absolute;
            top: 0.85rem;
            left: 0.85rem;
            padding: 0.25rem 0.7rem;
            border-radius: 999px;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            z-index: 10;
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }
        .badge-now {
            background: rgba(232,52,10,0.92);
            color: #fff;
            box-shadow: 0 2px 12px rgba(232,52,10,0.5);
        }
        .badge-soon {
            background: rgba(245,197,24,0.92);
            color: #1a1300;
            box-shadow: 0 2px 12px rgba(245,197,24,0.4);
        }
        .badge-dot {
            width: 5px; height: 5px;
            border-radius: 50%;
            background: currentColor;
            animation: pulse-dot 1.4s ease-in-out infinite;
        }

        /* Rating badge top-right */
        .card-rating {
            position: absolute;
            top: 0.85rem;
            right: 0.85rem;
            background: rgba(245,197,24,0.15);
            border: 1px solid rgba(245,197,24,0.35);
            border-radius: 0.4rem;
            padding: 0.2rem 0.5rem;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--gold);
            display: flex;
            align-items: center;
            gap: 0.25rem;
            z-index: 10;
        }

        /* Card content — always visible at bottom */
        .card-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1.1rem;
            z-index: 10;
        }
        .card-title {
            font-weight: 700;
            font-size: 1rem;
            color: var(--text);
            margin-bottom: 0.2rem;
            line-height: 1.25;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .card-meta {
            font-size: 0.77rem;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        .card-meta .dot { opacity: 0.4; }

        /* Hover-reveal section */
        .card-reveal {
            margin-top: 0.65rem;
            opacity: 0;
            transform: translateY(8px);
            transition: opacity 0.3s ease 0.05s, transform 0.3s ease 0.05s;
        }
        .movie-card:hover .card-reveal {
            opacity: 1;
            transform: translateY(0);
        }
        .card-desc {
            font-size: 0.8rem;
            color: rgba(240,239,244,0.65);
            line-height: 1.45;
            margin-bottom: 0.75rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .card-showtime {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.78rem;
            color: var(--accent2);
            font-weight: 500;
            margin-bottom: 0.75rem;
        }
        .btn-view {
            display: block;
            width: 100%;
            padding: 0.55rem;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 0.55rem;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.2s, box-shadow 0.2s, transform 0.15s;
        }
        .btn-view:hover {
            background: #c42908;
            color: #fff;
            box-shadow: 0 4px 20px rgba(232,52,10,0.5);
            transform: translateY(-1px);
        }

        /* ── GENRE TAG ───────────────────────────────────────────────────── */
        .genre-tag {
            display: inline-block;
            padding: 0.18rem 0.55rem;
            background: rgba(255,255,255,0.08);
            border-radius: 0.3rem;
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--muted);
            letter-spacing: 0.5px;
        }

        /* ── EMPTY STATE ─────────────────────────────────────────────────── */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 5rem 2rem;
        }
        .empty-state i {
            font-size: 4rem;
            color: var(--surface3);
            margin-bottom: 1rem;
            display: block;
        }
        .empty-state h3 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.8rem;
            letter-spacing: 1px;
            color: var(--muted);
            margin-bottom: 0.5rem;
        }
        .empty-state p { color: var(--muted); font-size: 0.9rem; }

        /* ── MOVIE COUNT ─────────────────────────────────────────────────── */
        .result-count {
            text-align: center;
            color: var(--muted);
            font-size: 0.85rem;
            margin-bottom: 1.5rem;
            padding: 0 2rem;
        }
        .result-count strong { color: var(--text); }

        /* ── NAVBAR USER ─────────────────────────────────────────────────── */
        .navbar-user { display: flex; align-items: center; gap: 0.75rem; }
        .navbar-text.welcome-text {
            font-family: 'Bebas Neue', sans-serif;
            letter-spacing: 0.8px;
            color: var(--text) !important;
        }

        /* ── SCROLL FADE-IN ──────────────────────────────────────────────── */
        .movie-card {
            animation: card-in 0.45s ease both;
        }
        @keyframes card-in {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        /* stagger via nth-child */
        .movie-card:nth-child(1)  { animation-delay: 0.05s; }
        .movie-card:nth-child(2)  { animation-delay: 0.10s; }
        .movie-card:nth-child(3)  { animation-delay: 0.15s; }
        .movie-card:nth-child(4)  { animation-delay: 0.20s; }
        .movie-card:nth-child(5)  { animation-delay: 0.25s; }
        .movie-card:nth-child(6)  { animation-delay: 0.30s; }
        .movie-card:nth-child(7)  { animation-delay: 0.35s; }
        .movie-card:nth-child(8)  { animation-delay: 0.40s; }
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
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('movies.index') ? 'active' : '' }}"
                       href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Movies
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item {{ request('status') === 'now-showing' ? 'active' : '' }}"
                               href="{{ route('movies.index', ['status' => 'now-showing']) }}">Now Showing</a></li>
                        <li><a class="dropdown-item {{ request('status') === 'coming-soon' ? 'active' : '' }}"
                               href="{{ route('movies.index', ['status' => 'coming-soon']) }}">Coming Soon</a></li>
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

    <!-- HERO HEADER -->
    <div class="page-hero">
        <div class="film-strip"></div>

        @if(request('status') === 'now-showing')
            <div class="hero-eyebrow">
                <span class="live-dot"></span> Live in Cinemas
            </div>
            <h1 class="hero-title">NOW <span>SHOWING</span></h1>
            <p class="hero-subtitle">Grab your seats before they're gone. These films are playing right now.</p>

        @elseif(request('status') === 'coming-soon')
            <div class="hero-eyebrow">
                <i class="bi bi-calendar-event"></i> Coming Up
            </div>
            <h1 class="hero-title">COMING <span>SOON</span></h1>
            <p class="hero-subtitle">Mark your calendar — these blockbusters are heading your way.</p>

        @else
            <div class="hero-eyebrow">
                <i class="bi bi-film"></i> Full Catalogue
            </div>
            <h1 class="hero-title">ALL <span>MOVIES</span></h1>
            <p class="hero-subtitle">Browse our entire collection of films across all showtimes.</p>
        @endif
    </div>

    <!-- SEARCH & FILTER BAR -->
    <div class="filter-bar">
        <form method="GET" action="{{ route('movies.index') }}" class="d-flex align-items-center gap-2 flex-wrap justify-content-center">
            <input type="hidden" name="status" value="{{ request('status') }}">
            <div class="search-wrap">
                <i class="bi bi-search"></i>
                <input type="text" name="search" placeholder="Search movies…" value="{{ $search ?? '' }}">
            </div>
            <button type="submit" style="display:none"></button>
        </form>

        <a href="{{ route('movies.index') }}"
           class="filter-pill {{ !request('status') ? 'active' : '' }}">
            <i class="bi bi-grid-3x3-gap-fill"></i> All
        </a>
        <a href="{{ route('movies.index', ['status' => 'now-showing']) }}"
           class="filter-pill {{ request('status') === 'now-showing' ? 'active' : '' }}">
            <i class="bi bi-play-circle"></i> Now Showing
        </a>
        <a href="{{ route('movies.index', ['status' => 'coming-soon']) }}"
           class="filter-pill {{ request('status') === 'coming-soon' ? 'active' : '' }}">
            <i class="bi bi-calendar2-week"></i> Coming Soon
        </a>
    </div>

    <!-- RESULT COUNT -->
    @if($movies->count())
        <p class="result-count">
            <strong>{{ $movies->count() }}</strong> movie{{ $movies->count() === 1 ? '' : 's' }} found
        </p>
    @endif

    <!-- MOVIE GRID -->
    <div class="movies-grid">
        @forelse($movies as $movie)
            <div class="movie-card">
                <!-- Poster -->
                <div class="card-poster"
                     style="background-image: url('{{ $movie->poster_url }}');">
                </div>

                <!-- Gradients -->
                <div class="card-gradient"></div>
                <div class="card-hover-overlay"></div>

                <!-- Status Badge -->
                @if(request('status') === 'now-showing' || ($movie->nextShowtime && $movie->nextShowtime->start_time->isToday()))
                    <div class="card-badge badge-now">
                        <span class="badge-dot"></span> Now Showing
                    </div>
                @elseif(request('status') === 'coming-soon' || ($movie->nextShowtime && $movie->nextShowtime->start_time->isFuture()))
                    <div class="card-badge badge-soon">
                        <i class="bi bi-calendar-check" style="font-size:0.7rem;"></i> Coming Soon
                    </div>
                @endif

                <!-- Rating Top-Right -->
                @if($movie->reviews_count)
                    <div class="card-rating">
                        <i class="bi bi-star-fill"></i>
                        {{ number_format($movie->reviews_avg_rating, 1) }}
                    </div>
                @endif

                <!-- Bottom Content -->
                <div class="card-content">
                    <div class="card-title">{{ $movie->title }}</div>
                    <div class="card-meta">
                        <span class="genre-tag">{{ $movie->genre->name ?? 'N/A' }}</span>
                        <span class="dot">·</span>
                        <span>{{ $movie->duration }} min</span>
                    </div>

                    <!-- Hover Reveal -->
                    <div class="card-reveal">
                        <p class="card-desc">{{ Str::limit($movie->description, 110) }}</p>

                        @if($movie->nextShowtime)
                            <div class="card-showtime">
                                <i class="bi bi-clock"></i>
                                {{ $movie->nextShowtime->start_time->format('M d · g:i A') }}
                            </div>
                        @else
                            <div class="card-showtime" style="color: var(--muted);">
                                <i class="bi bi-calendar-x"></i> No upcoming shows
                            </div>
                        @endif

                        <a href="{{ route('movies.show', $movie) }}" class="btn-view">
                            View Details &amp; Book →
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="bi bi-film"></i>
                <h3>No Movies Found</h3>
                <p>
                    @if($search)
                        No results for "<strong>{{ $search }}</strong>". Try a different search.
                    @elseif(request('status') === 'now-showing')
                        No films are currently showing. Check back soon!
                    @elseif(request('status') === 'coming-soon')
                        No upcoming films yet. Stay tuned!
                    @else
                        No movies available right now.
                    @endif
                </p>
            </div>
        @endforelse
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Submit search form on Enter
        document.querySelector('.search-wrap input')?.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') this.closest('form').submit();
        });
        // Live search on type (debounced)
        let debounceTimer;
        document.querySelector('.search-wrap input')?.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => this.closest('form').submit(), 500);
        });
    </script>
</body>
</html>