<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CineMax</title>
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
            overflow-x: hidden;
        }

        /* ── NAVBAR ── */
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
        }

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

        .avatar-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--surface2);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: border-color 0.2s;
            color: var(--muted);
        }

        .avatar-btn:hover { border-color: var(--accent); color: var(--text); }

        /* ── HERO ── */
        .hero {
            position: relative;
            min-height: 560px;
            display: flex;
            align-items: flex-end;
            overflow: hidden;
            margin: 1.5rem 1.5rem 3rem;
            border-radius: 1.25rem;
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 70% 30%, rgba(21,70,140,0.35) 0%, transparent 60%),
                radial-gradient(ellipse 50% 50% at 20% 80%, rgba(232,52,10,0.2) 0%, transparent 50%),
                linear-gradient(135deg, #0a1628 0%, #0d0d1a 40%, #1a0810 100%);
        }

        /* Film-strip top bar */
        .hero-filmstrip {
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 28px;
            background: rgba(0,0,0,0.6);
            display: flex;
            align-items: center;
            gap: 0;
            overflow: hidden;
        }

        .hero-filmstrip span {
            display: inline-block;
            width: 22px;
            height: 14px;
            background: rgba(255,255,255,0.07);
            border-radius: 2px;
            margin: 0 4px;
            flex-shrink: 0;
        }

        /* Floating poster on right */
        .hero-poster-wrap {
            position: absolute;
            right: 5%;
            top: 50%;
            transform: translateY(-50%);
            width: 200px;
        }

        .hero-poster {
            width: 200px;
            height: 300px;
            border-radius: 0.75rem;
            background: linear-gradient(160deg, #1a3a6e 0%, #0d1f3e 40%, #1a0f2e 100%);
            border: 1px solid rgba(255,255,255,0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 5rem;
            box-shadow: 0 30px 80px rgba(0,0,0,0.6), 0 0 0 1px rgba(255,255,255,0.05);
            position: relative;
            overflow: hidden;
        }

        .hero-poster::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, transparent 50%);
            pointer-events: none;
        }

        .poster-shine {
            position: absolute;
            top: -40%;
            left: -30%;
            width: 60%;
            height: 80%;
            background: linear-gradient(120deg, transparent 40%, rgba(255,255,255,0.06) 50%, transparent 60%);
            animation: shine 4s ease-in-out infinite 1s;
        }

        @keyframes shine {
            0% { transform: translateX(-100%) rotate(15deg); }
            30%, 100% { transform: translateX(300%) rotate(15deg); }
        }

        .hero-poster-label {
            position: absolute;
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--accent);
            color: white;
            font-size: 0.65rem;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            white-space: nowrap;
        }

        /* Gradient overlay over hero */
        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to right,
                rgba(13,13,15,0.98) 0%,
                rgba(13,13,15,0.85) 45%,
                rgba(13,13,15,0.2) 70%,
                transparent 100%
            );
        }

        .hero-content {
            position: relative;
            z-index: 2;
            padding: 3rem 3.5rem;
            max-width: 58%;
        }
        .hero .carousel-inner,
        .hero .carousel-item {
            height: 100%;
        }

        .trending-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: rgba(232,52,10,0.15);
            border: 1px solid rgba(232,52,10,0.4);
            color: var(--accent2);
            padding: 0.3rem 0.8rem;
            border-radius: 2rem;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 1.25rem;
        }

        .hero-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(3.5rem, 7vw, 5.5rem);
            line-height: 0.95;
            letter-spacing: 2px;
            color: var(--text);
            margin-bottom: 1.25rem;
        }

        .hero-title span {
            color: var(--accent);
        }

        .hero-tags {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-bottom: 1.25rem;
        }

        .hero-tag {
            font-size: 0.78rem;
            color: var(--muted);
            border: 1px solid var(--border);
            padding: 0.2rem 0.65rem;
            border-radius: 0.25rem;
            letter-spacing: 0.3px;
        }

        .hero-rating {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.85rem;
            margin-bottom: 1rem;
        }

        .stars {
            color: var(--gold);
            font-size: 0.8rem;
            letter-spacing: 1px;
        }

        .rating-num {
            font-weight: 600;
            color: var(--text);
        }

        .rating-count {
            color: var(--muted);
            font-size: 0.8rem;
        }

        .hero-desc {
            color: var(--muted);
            font-size: 0.9rem;
            line-height: 1.7;
            margin-bottom: 2rem;
            max-width: 440px;
        }

        .hero-actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn-book {
            background: var(--accent);
            color: white;
            border: none;
            padding: 0.7rem 1.6rem;
            border-radius: 0.4rem;
            font-family: 'DM Sans', sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: background 0.2s, transform 0.15s;
            text-decoration: none;
        }

        .btn-book:hover {
            background: #c42908;
            transform: translateY(-2px);
            color: white;
        }

        .btn-trailer {
            background: transparent;
            color: var(--text);
            border: 1px solid var(--border);
            padding: 0.7rem 1.4rem;
            border-radius: 0.4rem;
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
            font-size: 0.9rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: border-color 0.2s, background 0.2s;
            text-decoration: none;
        }

        .btn-trailer:hover {
            border-color: rgba(240,239,244,0.3);
            background: rgba(240,239,244,0.05);
            color: var(--text);
        }

        /* ── SECTION HEADER ── */
        .section-header {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.8rem;
            letter-spacing: 1.5px;
            color: var(--text);
        }

        .section-sub {
            color: var(--muted);
            font-size: 0.82rem;
            margin-top: 0.15rem;
        }

        .see-all {
            color: var(--accent);
            font-size: 0.82rem;
            font-weight: 500;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            transition: gap 0.2s;
        }

        .see-all:hover { gap: 0.6rem; color: var(--accent2); }

        /* ── FILTER PILLS ── */
        .filter-bar {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .filter-pill {
            background: var(--surface2);
            border: 1px solid var(--border);
            color: var(--muted);
            padding: 0.4rem 1rem;
            border-radius: 2rem;
            font-size: 0.8rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            letter-spacing: 0.3px;
        }

        .filter-pill:hover {
            border-color: rgba(232,52,10,0.4);
            color: var(--text);
        }

        .filter-pill.active {
            background: var(--accent);
            border-color: var(--accent);
            color: white;
        }

        /* ── MOVIE CARDS ── */
        .movie-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.25rem;
            margin-bottom: 4rem;
        }

        .movie-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 0.75rem;
            overflow: hidden;
            transition: transform 0.25s, border-color 0.25s, box-shadow 0.25s;
            cursor: pointer;
            position: relative;
        }

        .movie-link {
            color: inherit;
            text-decoration: none;
            display: block;
        }

        .movie-link:hover .card-title {
            text-decoration: underline;
        }

        .movie-card:hover {
            transform: translateY(-6px);
            border-color: rgba(232,52,10,0.4);
            box-shadow: 0 20px 50px rgba(0,0,0,0.5), 0 0 0 1px rgba(232,52,10,0.2);
        }

        .movie-card:hover .card-overlay { opacity: 1; }

        .card-poster {
            width: 100%;
            height: 270px;
            object-fit: contain;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
            position: relative;
            overflow: hidden;
        }

        .poster-img-wrapper {
            position: relative;
            width: 100%;
            height: 270px;
            overflow: hidden;
            background: #0b0b0d;
        }

        .poster-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
            display: block;
        }

        .card-overlay {
            position: absolute;
            inset: 0;
            background: rgba(13,13,15,0.65);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.25s;
        }

        .play-btn {
            width: 50px;
            height: 50px;
            background: var(--accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            transform: scale(0.85);
            transition: transform 0.2s;
        }

        .movie-card:hover .play-btn { transform: scale(1); }

        .rating-badge {
            position: absolute;
            top: 0.6rem;
            right: 0.6rem;
            background: rgba(13,13,15,0.85);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(245,197,24,0.3);
            border-radius: 0.35rem;
            padding: 0.2rem 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--gold);
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .card-body {
            padding: 1rem 1rem 1.1rem;
        }

        .card-title {
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 0.4rem;
            color: var(--text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .card-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: var(--muted);
            font-size: 0.78rem;
            margin-bottom: 0.75rem;
        }

        .card-meta span { display: flex; align-items: center; gap: 0.25rem; }

        .genre-tags {
            display: flex;
            gap: 0.4rem;
            flex-wrap: wrap;
        }

        .genre-tag {
            font-size: 0.7rem;
            font-weight: 500;
            padding: 0.2rem 0.55rem;
            border-radius: 0.25rem;
            background: rgba(232,52,10,0.1);
            border: 1px solid rgba(232,52,10,0.25);
            color: #ff7350;
            letter-spacing: 0.3px;
        }

        /* ── FOOTER ── */
        footer {
            background: var(--surface);
            border-top: 1px solid var(--border);
            padding: 3rem 0 2rem;
        }

        .footer-brand {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.6rem;
            color: var(--accent);
            letter-spacing: 2px;
            margin-bottom: 0.5rem;
        }

        .footer-tagline {
            color: var(--muted);
            font-size: 0.82rem;
            line-height: 1.6;
            max-width: 220px;
        }

        .footer-heading {
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 1rem;
        }

        footer ul { list-style: none; padding: 0; }
        footer ul li { margin-bottom: 0.5rem; }

        footer a {
            color: rgba(240,239,244,0.6);
            text-decoration: none;
            font-size: 0.87rem;
            transition: color 0.2s;
        }

        footer a:hover { color: var(--text); }

        footer hr {
            border-color: var(--border);
            margin: 2rem 0 1rem;
        }

        .footer-copy {
            color: var(--muted);
            font-size: 0.78rem;
            text-align: center;
        }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .hero-content > * {
            animation: fadeUp 0.6s ease both;
        }

        .hero-content > *:nth-child(1) { animation-delay: 0.05s; }
        .hero-content > *:nth-child(2) { animation-delay: 0.12s; }
        .hero-content > *:nth-child(3) { animation-delay: 0.18s; }
        .hero-content > *:nth-child(4) { animation-delay: 0.24s; }
        .hero-content > *:nth-child(5) { animation-delay: 0.3s;  }
        .hero-content > *:nth-child(6) { animation-delay: 0.36s; }

        .movie-card {
            animation: fadeUp 0.5s ease both;
        }

        .movie-card:nth-child(1) { animation-delay: 0.05s; }
        .movie-card:nth-child(2) { animation-delay: 0.1s; }
        .movie-card:nth-child(3) { animation-delay: 0.15s; }
        .movie-card:nth-child(4) { animation-delay: 0.2s; }
        .movie-card:nth-child(5) { animation-delay: 0.25s; }
        .movie-card:nth-child(6) { animation-delay: 0.3s; }
        .movie-card:nth-child(7) { animation-delay: 0.35s; }
        .movie-card:nth-child(8) { animation-delay: 0.4s; }

        /* Responsive */
        @media (max-width: 768px) {
            .hero { margin: 1rem; min-height: 480px; }
            .hero-content { max-width: 100%; padding: 2rem; }
            .hero-poster-wrap { display: none; }
            .hero-overlay {
                background: linear-gradient(to top,
                    rgba(13,13,15,0.98) 0%,
                    rgba(13,13,15,0.75) 60%,
                    rgba(13,13,15,0.3) 100%
                );
            }
            .movie-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 480px) {
            .hero-title { font-size: 3rem; }
            .hero-content { padding: 1.5rem; }
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
                    </ul>
                </div>
                @if(Auth::check())
                    <a href="{{ route('bookings.index') }}" class="btn btn-outline-light btn-sm">My Bookings</a>
                @endif
            </div>

            <div class="navbar-user">
                @include('partials.user-menu')
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-bg"></div>
        <div class="hero-filmstrip">
            <span></span><span></span><span></span><span></span><span></span>
            <span></span><span></span><span></span><span></span><span></span>
            <span></span><span></span><span></span><span></span><span></span>
            <span></span><span></span><span></span><span></span><span></span>
            <span></span><span></span><span></span><span></span><span></span>
        </div>
        <div class="hero-overlay"></div>

        <div id="comingSoonHeroCarousel" class="carousel slide w-100 h-100" data-bs-ride="carousel" data-bs-interval="4500">
            <div class="carousel-inner w-100 h-100">
                @forelse($comingSoonMovies as $comingSoonMovie)
                    <div class="carousel-item w-100 h-100 {{ $loop->first ? 'active' : '' }}">
                        <div class="hero-poster-wrap">
                            <div class="hero-poster">
                                <img src="{{ $comingSoonMovie->poster_url }}" alt="{{ $comingSoonMovie->title }} Poster" style="width: 100%; height: 100%; object-fit: cover;">
                                <div class="poster-shine"></div>
                            </div>
                            <div class="hero-poster-label">Coming Soon</div>
                        </div>

                        <div class="hero-content">
                            <div class="trending-pill">
                                <i class="bi bi-calendar-event"></i> Coming Soon
                            </div>
                            <h1 class="hero-title">{{ $comingSoonMovie->title }}</h1>
                            <div class="hero-tags">
                                <span class="hero-tag">{{ $comingSoonMovie->genre->name ?? 'Unknown' }}</span>
                                <span class="hero-tag">{{ floor($comingSoonMovie->duration / 60) }}h {{ $comingSoonMovie->duration % 60 }}m</span>
                                <span class="hero-tag">{{ optional($comingSoonMovie->release_date)->format('M d, Y') }}</span>
                            </div>
                            <p class="hero-desc">
                                {{ \Illuminate\Support\Str::limit($comingSoonMovie->description, 220) }}
                            </p>
                            <div class="hero-actions">
                                <a href="{{ route('movies.show', $comingSoonMovie) }}" class="btn-book">
                                    <i class="bi bi-eye-fill"></i> View Details
                                </a>
                                <a href="{{ route('movies.index', ['status' => 'coming-soon']) }}" class="btn-trailer">
                                    <i class="bi bi-collection-play"></i> See Coming Soon
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="carousel-item active w-100 h-100">
                        <div class="hero-content">
                            <div class="trending-pill">
                                <i class="bi bi-calendar-event"></i> Coming Soon
                            </div>
                            <h1 class="hero-title">Coming Soon</h1>
                            <p class="hero-desc">New upcoming movies will appear here as soon as they are added.</p>
                            <div class="hero-actions">
                                <a href="{{ route('movies.index') }}" class="btn-book">
                                    <i class="bi bi-film"></i> Browse Movies
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- NOW SHOWING -->
    <div class="container-lg px-4">
        <div class="section-header">
            <div>
                <div class="section-title">Now Showing</div>
                <div class="section-sub">Choose from our latest blockbusters</div>
            </div>
            <a href="#" class="see-all">See all <i class="bi bi-arrow-right"></i></a>
        </div>

        <!-- Filter Pills -->
        <div class="filter-bar" id="filterBar">
            <button class="filter-pill active" data-genre="all">All</button>
            <button class="filter-pill" data-genre="action">Action</button>
            <button class="filter-pill" data-genre="comedy">Comedy</button>
            <button class="filter-pill" data-genre="drama">Drama</button>
            <button class="filter-pill" data-genre="fantasy">Fantasy</button>
            <button class="filter-pill" data-genre="horror">Horror</button>
            <button class="filter-pill" data-genre="mystery">Mystery</button>
            <button class="filter-pill" data-genre="romance">Romance</button>
            <button class="filter-pill" data-genre="sci-fi">Sci-Fi</button>
            <button class="filter-pill" data-genre="thriller">Thriller</button>
            <button class="filter-pill" data-genre="family">Family</button>
        </div>

        <!-- Movie Grid -->
        <div class="movie-grid" id="movieGrid">
            @foreach($movies as $movie)
            <div class="movie-card" data-genres="{{ strtolower($movie->genre->name ?? 'unknown') }}">
                <a href="{{ route('movies.show', $movie) }}" class="movie-link">
                    <div class="poster-img-wrapper">
                        <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }}" class="card-poster">
                        <div class="rating-badge">
                            <i class="bi bi-star-fill"></i>
                            @if($movie->reviews_count)
                                {{ number_format($movie->reviews_avg_rating, 1) }}
                            @else
                                New
                            @endif
                        </div>
                        <div class="card-overlay"><div class="play-btn"><i class="bi bi-play-fill"></i></div></div>
                    </div>
                </a>
                <div class="card-body">
                    <a href="{{ route('movies.show', $movie) }}" class="movie-link">
                        <div class="card-title">{{ $movie->title }}</div>
                    </a>
                    <div class="card-meta">
                        <span><i class="bi bi-clock"></i> {{ floor($movie->duration / 60) }}h {{ $movie->duration % 60 }}m</span>
                    </div>
                    <div class="genre-tags">
                        <span class="genre-tag">{{ $movie->genre->name ?? 'Unknown' }}</span>
                    </div>
                    @if(Auth::check())
                        <a href="{{ route('movies.show', $movie) }}" class="btn btn-primary btn-sm mt-2">Book Now</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm mt-2">Login to Book</a>
                    @endif
                </div>
            </div>
            @endforeach
        </div><!-- /movie-grid -->
    </div><!-- /container -->

    <!-- FOOTER -->
    <footer>
        <div class="container-lg px-4">
            <div class="row g-4">
                <div class="col-md-4 col-lg-3">
                    <div class="footer-brand">CINEMAX</div>
                    <p class="footer-tagline">Your premier destination for the latest movies and unforgettable cinema experiences.</p>
                </div>
                <div class="col-6 col-md-2 offset-md-2 offset-lg-3">
                    <div class="footer-heading">Explore</div>
                    <ul>
                        <li><a href="/movies">Movies</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-2">
                    <div class="footer-heading">Support</div>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms</a></li>
                        <li><a href="#">Help Center</a></li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <div class="footer-heading">Connect</div>
                    <ul>
                        <li><a href="#"><i class="bi bi-facebook me-1"></i>Facebook</a></li>
                        <li><a href="#"><i class="bi bi-twitter-x me-1"></i>Twitter</a></li>
                        <li><a href="#"><i class="bi bi-instagram me-1"></i>Instagram</a></li>
                        <li><a href="#"><i class="bi bi-youtube me-1"></i>YouTube</a></li>
                    </ul>
                </div>
            </div>
            <hr>
            <p class="footer-copy">© 2026 CineMax. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Filter functionality
        const pills = document.querySelectorAll('.filter-pill');
        const cards = document.querySelectorAll('.movie-card');

        pills.forEach(pill => {
            pill.addEventListener('click', () => {
                pills.forEach(p => p.classList.remove('active'));
                pill.classList.add('active');

                const genre = pill.dataset.genre;

                cards.forEach(card => {
                    const genres = card.dataset.genres;
                    const show = genre === 'all' || genres.includes(genre);

                    card.style.transition = 'opacity 0.25s, transform 0.25s';
                    if (show) {
                        card.style.opacity = '1';
                        card.style.transform = '';
                        card.style.display = '';
                    } else {
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.95)';
                        setTimeout(() => {
                            if (!document.querySelector(`.filter-pill.active`).dataset.genre === 'all'
                                || genre !== 'all') {
                                card.style.display = 'none';
                            }
                        }, 240);
                    }
                });

                // Re-show after filtering
                setTimeout(() => {
                    cards.forEach(card => {
                        const genres = card.dataset.genres;
                        const show = genre === 'all' || genres.includes(genre);
                        if (show) card.style.display = '';
                    });
                }, 0);
            });
        });
    </script>
</body>
</html>