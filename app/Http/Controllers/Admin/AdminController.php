<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Roles;
use App\Models\Bookings;
use App\Models\Payments;
use App\Models\Movies;
use App\Models\Genres;
use App\Models\Cinemas;
use App\Models\Halls;
use App\Models\Showtimes;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // DASHBOARD
    public function dashboard()
    {
        $totalUsers = User::count();
        $revenue = Payments::where('status', 'paid')->sum('amount');
        $activeSessions = User::where('last_seen', '>=', now()->subHour())->count();
        
        // Dynamic error rate based on failed payments vs total payments
        $totalPayments = Payments::count();
        $failedPayments = Payments::where('status', 'failed')->count();
        $errorRate = $totalPayments > 0 ? round(($failedPayments / $totalPayments) * 100, 1) : 0;

        // Revenue Trend (Default 7 Days)
        $chartData = $this->getRevenueChartData(7);
        $days = $chartData['labels'];
        $revenueTrend = $chartData['data'];

        // Top Movies
        $topMovies = Movies::withCount(['showtimes as bookings_count' => function($q) {
            $q->whereHas('bookings', function($bq) { $bq->where('status', 'confirmed'); });
        }])
        ->orderBy('bookings_count', 'desc')
        ->take(5)
        ->get();

        // Booking Status Distribution
        $bookingStatus = [
            'confirmed' => Bookings::where('status', 'confirmed')->count(),
            'pending' => Bookings::where('status', 'pending')->count(),
            'canceled' => Bookings::where('status', 'canceled')->count(),
        ];

        // Recent Activity
        $recentBookings = Bookings::with(['user', 'showtime.movie'])->latest('date')->take(5)->get()->map(function($b) {
            return [
                'type' => 'booking',
                'title' => 'New booking created',
                'description' => ($b->user ? $b->user->name : 'Unknown User') . ' booked ' . ($b->showtime && $b->showtime->movie ? $b->showtime->movie->title : 'Unknown Movie'),
                'time' => $b->date ? $b->date->diffForHumans() : 'Unknown',
                'raw_time' => $b->date,
                'icon' => 'bi-ticket-fill',
                'color' => '#0d6efd',
                'bg' => 'rgba(13,110,253,0.1)'
            ];
        });

        $recentUsers = User::latest()->take(5)->get()->map(function($u) {
            return [
                'type' => 'user',
                'title' => 'New user registered',
                'description' => $u->name . ' signed up',
                'time' => $u->created_at->diffForHumans(),
                'raw_time' => $u->created_at,
                'icon' => 'bi-person-plus-fill',
                'color' => '#198754',
                'bg' => 'rgba(25,135,84,0.1)'
            ];
        });

        $recentActivity = $recentBookings->concat($recentUsers)->sortByDesc('raw_time')->take(5);

        return view('admin.dashboard', compact(
            'totalUsers', 
            'revenue', 
            'activeSessions', 
            'errorRate',
            'days',
            'revenueTrend',
            'topMovies',
            'bookingStatus',
            'recentActivity'
        ));
    }

    public function getRevenueChartData($daysCount = 7)
    {
        $days = collect(range($daysCount - 1, 0))->map(function($i) {
            return now()->subDays($i)->format('Y-m-d');
        });

        $revenueTrend = $days->map(function($date) {
            return Payments::whereDate('date', $date)->where('status', 'paid')->sum('amount');
        });

        return [
            'labels' => $days,
            'data' => $revenueTrend
        ];
    }

    public function getChartData(Request $request)
    {
        $days = $request->get('days', 7);
        return response()->json($this->getRevenueChartData($days));
    }

    public function analytics()
    {
        // KPI Data
        $totalBookings = Bookings::where('status', 'confirmed')->count();
        $totalRevenue = Payments::where('status', 'paid')->sum('amount');
        $avgTicketPrice = $totalBookings > 0 ? round($totalRevenue / $totalBookings, 2) : 0;
        
        // Occupancy Rate
        $totalCapacity = Showtimes::join('halls', 'showtimes.hall_id', '=', 'halls.id')->sum('halls.capacity');
        $bookedSeatsCount = \App\Models\Bookings_seats::whereHas('booking', function($q) {
            $q->where('status', 'confirmed');
        })->count();
        $occupancyRate = $totalCapacity > 0 ? round(($bookedSeatsCount / $totalCapacity) * 100, 1) : 0;

        // Cinema Performance
        $cinemaPerformance = Cinemas::with(['halls.showtimes.bookings' => function($q) {
            $q->where('status', 'confirmed');
        }])->get()->map(function($cinema) {
            $bookingsCount = 0;
            $revenue = 0;
            $capacity = 0;
            foreach($cinema->halls as $hall) {
                foreach($hall->showtimes as $showtime) {
                    $bookingsCount += $showtime->bookings->count();
                    $revenue += $showtime->bookings->count() * $showtime->price;
                    $capacity += $hall->capacity;
                }
            }
            return [
                'name' => $cinema->name,
                'bookings' => $bookingsCount,
                'revenue' => $revenue,
                'occupancy' => $capacity > 0 ? round(($bookingsCount / $capacity) * 100, 1) : 0
            ];
        });

        // Top Movies
        $topMovies = Movies::withCount(['showtimes as bookings_count' => function($q) {
            $q->whereHas('bookings', function($bq) { $bq->where('status', 'confirmed'); });
        }])
        ->orderBy('bookings_count', 'desc')
        ->take(5)
        ->get();

        // Trend Data (Last 7 Days)
        $days = collect(range(6, 0))->map(function($i) {
            return now()->subDays($i)->format('Y-m-d');
        });

        $bookingsTrend = $days->map(function($date) {
            return Bookings::whereDate('date', $date)->where('status', 'confirmed')->count();
        });

        $revenueTrend = $days->map(function($date) {
            return Payments::whereDate('date', $date)->where('status', 'paid')->sum('amount');
        });

        // Genre Popularity
        $genrePopularity = Genres::withCount(['movies as bookings_count' => function($q) {
            $q->whereHas('showtimes.bookings', function($bq) {
                $bq->where('status', 'confirmed');
            });
        }])->get();

        // Payment Methods
        $paymentMethods = Payments::select('method', \DB::raw('count(*) as count'))
            ->where('status', 'paid')
            ->groupBy('method')
            ->get();

        // User Growth
        $userGrowth = $days->map(function($date) {
            return User::whereDate('created_at', $date)->count();
        });

        return view('admin.analytics', compact(
            'totalBookings', 
            'totalRevenue', 
            'avgTicketPrice', 
            'occupancyRate',
            'cinemaPerformance',
            'topMovies',
            'days',
            'bookingsTrend',
            'revenueTrend',
            'genrePopularity',
            'paymentMethods',
            'userGrowth'
        ));
    }

    // USERS - LIST
    public function usersList(Request $request)
    {
        $query = User::with('role');

        // Search
        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
        }

        // Status filter
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Pagination
        $perPage = $request->per_page ?? 10;
        $users = $query->paginate($perPage);

        return view('admin.users.index', compact('users'));
    }

    // USERS - CREATE VIEW
    public function createUser()
    {
        $roles = Roles::all();
        return view('admin.users.form', compact('roles'));
    }

    // USERS - STORE
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:active,pending,banned',
            'email_verified' => 'nullable',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->role_id = $validated['role_id'];
        $user->status = $validated['status'];

        if ($request->email_verified) {
            $user->email_verified_at = now();
        }

        if ($request->hasFile('avatar')) {
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        return redirect()->route('admin.users.index')
                       ->with('success', 'User created successfully');
    }

    // USERS - EDIT VIEW
    public function editUser(User $user)
    {
        $roles = Roles::all();
        return view('admin.users.form', compact('user', 'roles'));
    }

    // USERS - UPDATE
    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$user->id}",
            'password' => 'nullable|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:active,pending,banned',
            'email_verified' => 'nullable',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role_id = $validated['role_id'];
        $user->status = $validated['status'];

        if ($validated['password'] ?? null) {
            $user->password = Hash::make($validated['password']);
        }

        if ($request->email_verified) {
            $user->email_verified_at = now();
        } else {
            $user->email_verified_at = null;
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        return redirect()->route('admin.users.index')
                       ->with('success', 'User updated successfully');
    }

    // USERS - DELETE
    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')
                       ->with('success', 'User deleted successfully');
    }

    // MOVIES MANAGEMENT
    public function moviesList(Request $request)
    {
        $query = Movies::with(['genre', 'showtime.hall.cinema'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews');

        // Search
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('genre', function($g) use ($search) {
                      $g->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Pagination
        $perPage = $request->per_page ?? 10;
        $movies = $query->paginate($perPage);

        return view('admin.movies.index', compact('movies'));
    }

    // MOVIES - CREATE VIEW
    public function createMovie()
    {
        $genres  = Genres::all();
        $cinemas = Cinemas::with('halls')->get();
    
        // Embed ALL future showtimes as a flat JSON-friendly array.
        // The Blade view will pass this to JavaScript — no API call needed.
        $allShowtimes = Showtimes::with('movie:id,title')
            ->where('start_time', '>=', now())
            ->orderBy('start_time')
            ->get()
            ->map(fn($st) => [
                'hall_id'    => $st->hall_id,
                'movie'      => $st->movie->title ?? 'Unknown',
                'start_time' => $st->start_time->format('Y-m-d H:i'),
                'end_time'   => $st->end_time->format('Y-m-d H:i'),
                'start_ts'   => $st->start_time->timestamp,
                'end_ts'     => $st->end_time->timestamp,
            ]);
    
        return view('admin.movies.form', compact('genres', 'cinemas', 'allShowtimes'));
    }

    private function hasConflict(
    int $hallId,
    string $startTime,
    int $durationMinutes,
    ?int $excludeId = null
    ): bool {
        $start = Carbon::parse($startTime);
        $end   = $start->copy()->addMinutes($durationMinutes);
    
        $query = Showtimes::where('hall_id', $hallId)
            ->where(function ($q) use ($start, $end) {
                // Standard interval overlap: A.start < B.end  AND  A.end > B.start
                $q->where('start_time', '<', $end)
                ->where('end_time',   '>', $start);
            });
    
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
    
        return $query->exists();
    }


    // MOVIES - STORE
    public function storeMovie(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'genre_id' => 'required|exists:genres,id',
            'release_date' => 'required|date',
            'duration' => 'required|integer|min:1',
            'poster' => 'nullable|image|max:2048',
            'trailer_url' => 'nullable|url|max:255',
            'showtimes' => 'required|array|min:1',
            'showtimes.*.hall_id' => 'required|exists:halls,id',
            'showtimes.*.start_time' => 'required|date',
            'showtimes.*.price' => 'required|numeric|min:0',
        ]);

        // ── Conflict check (add after $validated = ...) ───────────────────────
        foreach ($request->showtimes as $index => $stData) {
            if ($this->hasConflict(
                (int) $stData['hall_id'],
                $stData['start_time'],
                (int) $validated['duration']
            )) {
                $hall = \App\Models\Halls::find($stData['hall_id']);
                return back()->withInput()->withErrors([
                    "showtimes.{$index}.start_time" =>
                        'Hall "' . ($hall->name ?? 'selected') .
                        '" is already booked during this time. Choose a different time or hall.',
                ]);
            }
        }
        // ── End conflict check ────────────────────────────────────────────────


        $movie = new Movies();
        $movie->title = $validated['title'];
        $movie->description = $validated['description'];
        $movie->genre_id = $validated['genre_id'];
        $movie->release_date = $validated['release_date'];
        $movie->duration = $validated['duration'];
        $movie->trailer_url = $validated['trailer_url'] ?? null;

        if ($request->hasFile('poster')) {
            $movie->poster = $request->file('poster')->store('posters', 'public');
        }

        $movie->save();

        // Save showtimes
        foreach ($request->showtimes as $stData) {
            $showtime = new Showtimes();
            $showtime->movie_id = $movie->id;
            $showtime->hall_id = $stData['hall_id'];
            $showtime->start_time = $stData['start_time'];
            $showtime->price = $stData['price'];
            // End time calculation (start time + duration)
            $showtime->end_time = Carbon::parse($stData['start_time'])->addMinutes($movie->duration);
            $showtime->save();

            // Optionally update the first showtime ID to the movie record for legacy support
            if (!$movie->show_time_id) {
                $movie->show_time_id = $showtime->id;
                $movie->save();
            }
        }
        
        return redirect()->route('admin.movies.index')
                       ->with('success', 'Movie and showtimes created successfully');
    }

    // MOVIES - EDIT VIEW
    public function editMovie(Movies $movie)
    {
        $movie->load('showtimes.hall.cinema');
        $genres  = Genres::all();
        $cinemas = Cinemas::with('halls')->get();
    
        // Same flat array as createMovie — exclude this movie's own
        // showtimes so they don't show as conflicts against themselves.
        $allShowtimes = Showtimes::with('movie:id,title')
            ->where('movie_id', '!=', $movie->id)   // <-- exclude self
            ->where('start_time', '>=', now())
            ->orderBy('start_time')
            ->get()
            ->map(fn($st) => [
                'hall_id'    => $st->hall_id,
                'movie'      => $st->movie->title ?? 'Unknown',
                'start_time' => $st->start_time->format('Y-m-d H:i'),
                'end_time'   => $st->end_time->format('Y-m-d H:i'),
                'start_ts'   => $st->start_time->timestamp,
                'end_ts'     => $st->end_time->timestamp,
            ]);
    
        return view('admin.movies.form', compact('movie', 'genres', 'cinemas', 'allShowtimes'));
    }


    // MOVIES - UPDATE
    public function updateMovie(Request $request, Movies $movie)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'genre_id' => 'required|exists:genres,id',
            'release_date' => 'required|date',
            'duration' => 'required|integer|min:1',
            'poster' => 'nullable|image|max:2048',
            'trailer_url' => 'nullable|url|max:255',
            'showtimes' => 'required|array|min:1',
            'showtimes.*.id' => 'nullable|exists:showtimes,id',
            'showtimes.*.hall_id' => 'required|exists:halls,id',
            'showtimes.*.start_time' => 'required|date',
            'showtimes.*.price' => 'required|numeric|min:0',
        ]);

        // ── Conflict check (add after $validated = ...) ───────────────────────
        foreach ($request->showtimes as $index => $stData) {
        $excludeId = !empty($stData['id']) ? (int) $stData['id'] : null;
    
        if ($this->hasConflict(
            (int) $stData['hall_id'],
            $stData['start_time'],
            (int) $validated['duration'],
            $excludeId
        )) {
            $hall = \App\Models\Halls::find($stData['hall_id']);
            return back()->withInput()->withErrors([
                "showtimes.{$index}.start_time" =>
                    'Hall "' . ($hall->name ?? 'selected') .
                    '" is already booked during this time. Choose a different time or hall.',
            ]);
        }
    }
    // ── End conflict check ────────────────────────────────────────────────


        $movie->title = $validated['title'];
        $movie->description = $validated['description'];
        $movie->genre_id = $validated['genre_id'];
        $movie->release_date = $validated['release_date'];
        $movie->duration = $validated['duration'];
        $movie->trailer_url = $validated['trailer_url'] ?? null;

        if ($request->hasFile('poster')) {
            if ($movie->poster) {
                Storage::disk('public')->delete($movie->poster);
            }
            $movie->poster = $request->file('poster')->store('posters', 'public');
        }

        $movie->save();

        // Process showtimes
        $keepShowtimeIds = [];
        $firstShowtimeId = null;

        foreach ($request->showtimes as $stData) {
            if (isset($stData['id']) && !empty($stData['id'])) {
                // Update existing
                $showtime = Showtimes::find($stData['id']);
                if ($showtime && $showtime->movie_id == $movie->id) {
                    $showtime->hall_id = $stData['hall_id'];
                    $showtime->start_time = $stData['start_time'];
                    $showtime->price = $stData['price'];
                    $showtime->end_time = Carbon::parse($stData['start_time'])->addMinutes($movie->duration);
                    $showtime->save();
                    $keepShowtimeIds[] = $showtime->id;
                }
            } else {
                // Create new
                $showtime = new Showtimes();
                $showtime->movie_id = $movie->id;
                $showtime->hall_id = $stData['hall_id'];
                $showtime->start_time = $stData['start_time'];
                $showtime->price = $stData['price'];
                $showtime->end_time = Carbon::parse($stData['start_time'])->addMinutes($movie->duration);
                $showtime->save();
                $keepShowtimeIds[] = $showtime->id;
            }

            if (!$firstShowtimeId) {
                $firstShowtimeId = $showtime->id;
            }
        }

        // Delete removed showtimes that HAVE NO BOOKINGS
        $removedShowtimes = $movie->showtimes()->whereNotIn('id', $keepShowtimeIds)->get();
        foreach ($removedShowtimes as $rs) {
            if ($rs->bookings()->count() == 0) {
                $rs->delete();
            }
        }

        // Update the legacy show_time_id
        $movie->show_time_id = $firstShowtimeId;
        $movie->save();
        
        return redirect()->route('admin.movies.index')
                       ->with('success', 'Movie and showtimes updated successfully');
    }

    // MOVIES - DELETE
    public function deleteMovie(Movies $movie)
    {
        if ($movie->poster) {
            Storage::disk('public')->delete($movie->poster);
        }
        $movie->delete();
        return redirect()->route('admin.movies.index')
                       ->with('success', 'Movie deleted successfully');
    }

    // CINEMAS MANAGEMENT
    public function cinemasList(Request $request)
    {
        $query = Cinemas::query();

        // Search
        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('location', 'like', "%{$request->search}%");
        }

        // Pagination
        $perPage = $request->per_page ?? 10;
        $cinemas = $query->paginate($perPage);

        return view('admin.cinemas.index', compact('cinemas'));
    }

    // CINEMAS - CREATE VIEW
    public function createCinema()
    {
        return view('admin.cinemas.form');
    }

    // CINEMAS - STORE
    public function storeCinema(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $cinema = new Cinemas();
        $cinema->name = $validated['name'];
        $cinema->location = $validated['location'];
        $cinema->save();

        return redirect()->route('admin.cinemas.index')
                       ->with('success', 'Cinema created successfully');
    }

    // CINEMAS - EDIT VIEW
    public function editCinema(Cinemas $cinema)
    {
        return view('admin.cinemas.form', compact('cinema'));
    }

    // CINEMAS - UPDATE
    public function updateCinema(Request $request, Cinemas $cinema)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $cinema->name = $validated['name'];
        $cinema->location = $validated['location'];
        $cinema->save();

        return redirect()->route('admin.cinemas.index')
                       ->with('success', 'Cinema updated successfully');
    }

    // CINEMAS - DELETE
    public function deleteCinema(Cinemas $cinema)
    {
        $cinema->delete();
        return redirect()->route('admin.cinemas.index')
                       ->with('success', 'Cinema deleted successfully');
    }

    // HALLS MANAGEMENT
    public function storeHall(Request $request)
    {
        $validated = $request->validate([
            'cinema_id' => 'required|exists:cinemas,id',
            'name' => [
                'required',
                'string',
                'max:50',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = Halls::where('cinema_id', $request->cinema_id)
                        ->where('name', $value)
                        ->exists();
                    if ($exists) {
                        $fail('A hall with this name already exists in this cinema.');
                    }
                },
            ],
            'capacity' => 'required|integer|min:1',
            'screen_type' => 'nullable|string|max:50',
            'audio_system' => 'nullable|string|max:100',
            'screen_dimensions' => 'nullable|string|max:50',
            'projection_type' => 'required|in:2D,3D,IMAX',
        ]);

        $hall = new Halls();
        $hall->fill($validated);
        $hall->save();

        return back()->with('success', 'Hall created successfully');
    }

    public function updateHall(Request $request, Halls $hall)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                function ($attribute, $value, $fail) use ($hall) {
                    $exists = Halls::where('cinema_id', $hall->cinema_id)
                        ->where('name', $value)
                        ->where('id', '!=', $hall->id)
                        ->exists();
                    if ($exists) {
                        $fail('A hall with this name already exists in this cinema.');
                    }
                },
            ],
            'capacity' => 'required|integer|min:1',
            'screen_type' => 'nullable|string|max:50',
            'audio_system' => 'nullable|string|max:100',
            'screen_dimensions' => 'nullable|string|max:50',
            'projection_type' => 'required|in:2D,3D,IMAX',
        ]);

        $hall->update($validated);

        return back()->with('success', 'Hall updated successfully');
    }

    public function deleteHall(Halls $hall)
    {
        $hall->delete();
        return back()->with('success', 'Hall deleted successfully');
    }

    public function getHallsByCinema(Cinemas $cinema)
    {
        return response()->json($cinema->halls);
    }

    public function getShowtimesByHall($hallId)
    {
        $showtimes = Showtimes::where('hall_id', $hallId)
            ->where('start_time', '>=', now())
            ->orderBy('start_time')
            ->get();
        return response()->json($showtimes);
    }

    // BOOKINGS MANAGEMENT
    public function bookingsList(Request $request)
    {
        // Placeholder - similar to users
        return view('admin.bookings.index', ['bookings' => []]);
    }

    // SETTINGS
    public function settings()
    {
        return view('admin.settings');
    }
}
