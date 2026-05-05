<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $movie->title }} - CineMax</title>
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

        .container {
            padding: 2rem;
        }
        .trailer-section {
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 0.75rem;
            padding: 0.85rem;
            margin-bottom: 1.5rem;
        }
        .trailer-title {
            font-family: 'Bebas Neue', sans-serif;
            letter-spacing: 1px;
            font-size: 1.4rem;
            margin-bottom: 0.65rem;
            color: var(--text);
        }
        .trailer-frame-wrap {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%;
            height: 0;
            border-radius: 0.6rem;
            overflow: hidden;
            background: #000;
        }
        .trailer-frame-wrap iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        .movie-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 3rem;
            color: var(--accent);
            margin-bottom: 1rem;
            letter-spacing: 1px;
        }

        .movie-header {
            display: flex;
            gap: 2rem;
            margin-bottom: 2rem;
            align-items: flex-start;
        }

        .movie-poster {
            flex-shrink: 0;
            width: 250px;
        }

        .movie-info {
            flex: 1;
        }

        .movie-details {
            margin-bottom: 1rem;
        }

        .movie-description {
            color: var(--muted);
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .movie-meta {
            display: flex;
            gap: 2rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .meta-item {
            color: var(--text);
            font-weight: 500;
        }

        .showtime-card {
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .btn-book {
            background: var(--accent);
            color: white;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 0.4rem;
            font-family: 'DM Sans', sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
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

        .review-panel {
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-top: 2rem;
        }

        .review-panel h3 {
            margin-bottom: 1rem;
        }

        .review-item {
            border-top: 1px solid rgba(240,239,244,0.08);
            padding: 1rem 0;
        }

        .review-item:first-child {
            border-top: none;
        }

        .review-rating {
            color: var(--gold);
            margin-bottom: 0.5rem;
            display: inline-flex;
            gap: 0.15rem;
        }

        .review-author {
            color: var(--muted);
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        .review-comment {
            color: var(--text);
            line-height: 1.6;
        }

        .review-form textarea,
        .review-form select,
        .review-form input {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            color: var(--text);
            border-radius: 0.5rem;
            padding: 0.8rem 1rem;
            width: 100%;
            margin-bottom: 1rem;
        }

        .review-form select option {
            background: #222;
            color: #000;
        }

        .review-form label {
            display: block;
            margin-bottom: 0.4rem;
            color: var(--muted);
            font-size: 0.95rem;
        }

        .review-form button {
            background: var(--accent);
            color: white;
            border: none;
            padding: 0.75rem 1.25rem;
            border-radius: 0.5rem;
            cursor: pointer;
            font-weight: 600;
        }

        .review-form button:hover {
            background: #c42908;
            transform: translateY(-1px);
        }

        .review-summary {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }

        .review-summary span {
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

        .section-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2rem;
            color: var(--text);
            margin-bottom: 1rem;
            letter-spacing: 1px;
        }
        .cinema-picker {
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 0.75rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
        .cinema-picker .form-select {
            background-color: #ffffff;
            border: 1px solid rgba(255,255,255,0.1);
            color: #000000;
        }
        .cinema-picker .form-select:focus {
            border-color: rgba(232,52,10,0.5);
            box-shadow: 0 0 0 0.2rem rgba(232,52,10,0.2);
        }
        .cinema-picker .form-select option {
            color: #000000;
            background: #ffffff;
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
                    <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
        <div class="trailer-section">
            <h2 class="trailer-title">Trailer</h2>
            <div class="trailer-frame-wrap">
                <iframe
                    src="{{ $movie->trailer_embed_url }}"
                    title="{{ $movie->title }} Trailer"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen>
                </iframe>
            </div>
        </div>

        <div class="movie-header">
            <div class="movie-poster">
                <img src="{{ $movie->poster_url }}" alt="{{ $movie->title }} Poster" style="width: 100%; height: auto; border-radius: 0.75rem; box-shadow: 0 20px 50px rgba(0,0,0,0.5);">
            </div>
            <div class="movie-info">
                <h1 class="movie-title">{{ $movie->title }}</h1>
                <div class="movie-details">
                    <p class="movie-description">{{ $movie->description }}</p>
                    <div class="movie-meta">
                        <span class="meta-item">Genre: {{ $movie->genre->name }}</span>
                        <span class="meta-item">Duration: {{ $movie->duration }} min</span>
                        <span class="meta-item">Release Date: {{ $movie->release_date }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="cinema-picker">
            @if($showtimes->isNotEmpty())
                <button class="btn-book mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#bookingPanel" aria-expanded="false" aria-controls="bookingPanel">
                    Book Now
                </button>
                <div class="collapse" id="bookingPanel">
                    <label for="cinemaSelect" class="form-label">Choose a cinema:</label>
                    <select id="cinemaSelect" class="form-select">
                        <option value="">Select Cinema</option>
                        @foreach($cinemas as $cinema)
                            <option value="{{ $cinema->id }}">{{ $cinema->name }} - {{ $cinema->location }}</option>
                        @endforeach
                    </select>

                    <label for="hallSelect" class="form-label mt-3">Choose a hall:</label>
                    <select id="hallSelect" class="form-select" disabled>
                        <option value="">Select Hall</option>
                    </select>

                    @if(Auth::check())
                        <a id="bookSeatsBtn" href="#" class="btn-book mt-3 disabled" aria-disabled="true">Select Seats</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-book mt-3">Login to Book</a>
                    @endif
                </div>
            @else
                <div class="alert alert-info bg-dark text-light border-secondary">
                    <i class="bi bi-info-circle me-2"></i> No showtimes available for this movie yet.
                </div>
            @endif
        </div>

        <div class="review-panel">
            <h3>Movie Reviews</h3>

            <div class="review-summary">
                <strong>{{ $reviewCount }} review{{ $reviewCount === 1 ? '' : 's' }}</strong>
                @if($reviewCount)
                    <span>Average rating: {{ number_format($averageRating, 1) }} / 5</span>
                @else
                    <span>No reviews yet. Be the first to review this movie.</span>
                @endif
            </div>

            @if(session('success'))
                <div class="alert alert-success text-dark" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger text-dark" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger text-dark" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            @auth
                @if($alreadyReviewed)
                    {{-- User already submitted a review --}}
                    <div style="background: rgba(40,167,69,0.12); border: 1px solid rgba(40,167,69,0.35); border-radius: 0.6rem; padding: 1.25rem 1.5rem; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.75rem;">
                        <i class="bi bi-patch-check-fill" style="color: #28a745; font-size: 1.4rem; flex-shrink:0;"></i>
                        <div>
                            <strong style="color: #28a745;">Review submitted</strong>
                            <p style="margin: 0.2rem 0 0; color: var(--muted); font-size: 0.9rem;">Thank you for sharing your thoughts on this movie!</p>
                        </div>
                    </div>
                @elseif($canReview)
                    {{-- Eligible — show the review form --}}
                    <div style="background: rgba(232,52,10,0.08); border: 1px solid rgba(232,52,10,0.25); border-radius: 0.6rem; padding: 0.8rem 1.25rem; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.6rem;">
                        <i class="bi bi-star-fill" style="color: var(--gold);"></i>
                        <span style="font-size: 0.9rem; color: var(--muted);">You've watched this movie — share your experience!</span>
                    </div>
                    <form method="POST" action="{{ route('movies.reviews.store', $movie) }}" class="review-form">
                        @csrf
                        <div>
                            <label for="rating">Your rating</label>
                            <select id="rating" name="rating" required>
                                <option value="">Select rating</option>
                                @for($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }} star{{ $i === 1 ? '' : 's' }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label for="comment">Your review</label>
                            <textarea id="comment" name="comment" rows="4" required>{{ old('comment') }}</textarea>
                        </div>
                        <button type="submit">Submit review</button>
                    </form>
                @elseif($reviewableAfter)
                    {{-- Has a confirmed booking but movie hasn't ended yet --}}
                    <div style="background: rgba(245,197,24,0.1); border: 1px solid rgba(245,197,24,0.3); border-radius: 0.6rem; padding: 1.25rem 1.5rem; display: flex; align-items: flex-start; gap: 0.75rem;">
                        <i class="bi bi-hourglass-split" style="color: var(--gold); font-size: 1.4rem; flex-shrink:0; margin-top:0.1rem;"></i>
                        <div>
                            <strong style="color: var(--gold);">Review unlocks after the movie ends</strong>
                            <p style="margin: 0.3rem 0 0; color: var(--muted); font-size: 0.9rem;">
                                You have a confirmed booking for this movie.<br>
                                You'll be able to write a review after
                                <strong style="color: var(--text);">{{ \Carbon\Carbon::parse($reviewableAfter)->format('M j, Y \a\t g:i A') }}</strong>.
                            </p>
                        </div>
                    </div>
                @else
                    {{-- Logged in but no confirmed booking --}}
                    <div style="background: rgba(23,162,184,0.08); border: 1px solid rgba(23,162,184,0.25); border-radius: 0.6rem; padding: 1.1rem 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                        <i class="bi bi-ticket-perforated" style="color: #17a2b8; font-size: 1.3rem; flex-shrink:0;"></i>
                        <p style="margin: 0; color: var(--muted); font-size: 0.9rem;">
                            You need to <strong style="color: var(--text);">book and watch this movie</strong> before you can leave a review.
                        </p>
                    </div>
                @endif
            @else
                <p style="color: var(--text);">Please <a href="{{ route('login') }}">login</a> and watch the movie to write a review.</p>
            @endauth

            @foreach($reviews as $review)
                <div class="review-item">
                    <div class="review-rating">
                        @for($star = 1; $star <= 5; $star++)
                            <i class="bi bi-star-fill" style="opacity: {{ $star <= $review->rating ? '1' : '0.25' }}"></i>
                        @endfor
                    </div>
                    <div class="review-author">By {{ $review->user->name ?? 'Anonymous' }}</div>
                    <div class="review-comment">{{ $review->comment }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script id="dataScript" type="application/json">
        {
            "cinemaToHalls": {!! json_encode((object)$cinemaToHalls) !!},
            "hallToShowtime": {!! json_encode((object)$hallToShowtime) !!}
        }
    </script>
    <script>
        // Parse data from script tag
        let cinemaToHalls = {};
        let hallToShowtime = {};
        
        try {
            const dataScript = document.getElementById('dataScript');
            if (dataScript) {
                const data = JSON.parse(dataScript.textContent);
                cinemaToHalls = data.cinemaToHalls || {};
                hallToShowtime = data.hallToShowtime || {};
                console.log('Booking data loaded:', { cinemaToHalls, hallToShowtime });
            }
        } catch (e) {
            console.error('Error parsing booking data:', e);
        }

        const cinemaSelect = document.getElementById('cinemaSelect');
        const hallSelect = document.getElementById('hallSelect');
        const bookSeatsBtn = document.getElementById('bookSeatsBtn');

        const disableBookButton = () => {
            if (!bookSeatsBtn) return;
            bookSeatsBtn.classList.add('disabled');
            bookSeatsBtn.setAttribute('aria-disabled', 'true');
            bookSeatsBtn.style.pointerEvents = 'none';
            bookSeatsBtn.setAttribute('href', '#');
        };

        const enableBookButton = (showtimeId) => {
            if (!bookSeatsBtn) return;
            if (!showtimeId) {
                disableBookButton();
                return;
            }
            bookSeatsBtn.classList.remove('disabled');
            bookSeatsBtn.setAttribute('aria-disabled', 'false');
            bookSeatsBtn.style.pointerEvents = 'auto';
            bookSeatsBtn.setAttribute('href', `{{ route('bookings.create') }}?showtime=${showtimeId}`);
        };

        if (cinemaSelect && hallSelect) {
            cinemaSelect.addEventListener('change', function () {
                const cinemaId = this.value;
                console.log('Cinema selected:', cinemaId);
                
                const halls = cinemaToHalls[cinemaId] || [];
                console.log('Halls for cinema:', halls);

                hallSelect.innerHTML = '';
                disableBookButton();

                if (!cinemaId) {
                    const defaultOption = document.createElement('option');
                    defaultOption.value = '';
                    defaultOption.textContent = 'Select Cinema First';
                    hallSelect.appendChild(defaultOption);
                    hallSelect.disabled = true;
                    return;
                }

                if (halls.length === 0) {
                    const noHallsOption = document.createElement('option');
                    noHallsOption.value = '';
                    noHallsOption.textContent = 'No halls available';
                    hallSelect.appendChild(noHallsOption);
                    hallSelect.disabled = true;
                    return;
                }

                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'Select Hall';
                hallSelect.appendChild(defaultOption);

                halls.forEach((hall) => {
                    const option = document.createElement('option');
                    option.value = hall.id;
                    option.textContent = hall.name;
                    hallSelect.appendChild(option);
                });

                hallSelect.disabled = false;
                console.log('Hall select enabled');
            });

            hallSelect.addEventListener('change', function () {
                const hallId = this.value;
                console.log('Hall selected:', hallId);
                const showtimeId = hallToShowtime[hallId];
                console.log('Showtime ID:', showtimeId);
                enableBookButton(showtimeId);
            });

            // Auto-select first cinema if available and nothing is selected
            if (cinemaSelect.options.length > 1 && !cinemaSelect.value) {
                console.log('Auto-selecting first cinema');
                cinemaSelect.selectedIndex = 1;
                cinemaSelect.dispatchEvent(new Event('change'));
            }
        }
    </script>
</body>
</html>