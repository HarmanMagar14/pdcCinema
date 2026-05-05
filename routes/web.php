<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Carbon;
use App\Http\Controllers\CinemasController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\PayMongoWebhookController;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Movies;

Route::get('/', function () {
    $movies = Movies::with(['genre', 'showtime'])
        ->withAvg('reviews', 'rating')
        ->withCount('reviews')
        ->whereHas('showtime', function($q) {
            $q->whereDate('start_time', Carbon::today());
        })
        ->take(8)
        ->get();

    $comingSoonMovies = Movies::with(['genre', 'showtime'])
        ->whereHas('showtime', function($q) {
            $q->whereDate('start_time', '>', Carbon::today());
        })
        ->orderBy(
            \App\Models\Showtimes::select('start_time')
                ->whereColumn('movies.show_time_id', 'showtimes.id')
                ->limit(1)
        )
        ->take(5)
        ->get();

    return view('welcome', compact('movies', 'comingSoonMovies'));
});

Route::resource('movies', MoviesController::class);
Route::get('/cinemas', [CinemasController::class, 'index'])->name('cinemas.index');
Route::post('movies/{movie}/reviews', [ReviewsController::class, 'store'])->name('movies.reviews.store')->middleware('auth');
Route::resource('bookings', BookingsController::class)->middleware('auth');
Route::post('bookings/{booking}/pay', [BookingsController::class, 'pay'])->name('bookings.pay')->middleware('auth');
Route::get('bookings/{booking}/payment-success', [BookingsController::class, 'paymentSuccess'])->name('bookings.payment-success')->middleware('auth');
Route::post('bookings/{booking}/cancel', [BookingsController::class, 'cancel'])->name('bookings.cancel')->middleware('auth');

// PayMongo Webhook - outside of auth for webhook processing
Route::post('/webhooks/paymongo', [PayMongoWebhookController::class, 'handle'])->withoutMiddleware(['web']);

// Auth routes
Route::get('/otp',    [AuthController::class, 'showOtp'])->name('otp.show');
Route::post('/otp',   [AuthController::class, 'verifyOtp'])->name('otp.verify');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show')->middleware('auth');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar')->middleware('auth');


// ADMIN ROUTES
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
    Route::get('/api/chart-data', [AdminController::class, 'getChartData'])->name('api.chart-data');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    
    // Users Management
    Route::get('/users', [AdminController::class, 'usersList'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.destroy');
    
    // Movies Management
    Route::get('/movies', [AdminController::class, 'moviesList'])->name('movies.index');
    Route::get('/movies/create', [AdminController::class, 'createMovie'])->name('movies.create');
    Route::post('/movies', [AdminController::class, 'storeMovie'])->name('movies.store');
    Route::get('/movies/{movie}/edit', [AdminController::class, 'editMovie'])->name('movies.edit');
    Route::put('/movies/{movie}', [AdminController::class, 'updateMovie'])->name('movies.update');
    Route::delete('/movies/{movie}', [AdminController::class, 'deleteMovie'])->name('movies.destroy');
    Route::get('/movies/{movie}/showtimes',  [AdminController::class, 'showMovieShowtimes'])->name('movies.showtimes');
    Route::post('/movies/{movie}/showtimes', [AdminController::class, 'storeShowtimes'])->name('movies.showtimes.store');

    
    // Cinemas Management
    Route::get('/cinemas', [AdminController::class, 'cinemasList'])->name('cinemas.index');
    Route::get('/cinemas/create', [AdminController::class, 'createCinema'])->name('cinemas.create');
    Route::post('/cinemas', [AdminController::class, 'storeCinema'])->name('cinemas.store');
    Route::get('/cinemas/{cinema}/edit', [AdminController::class, 'editCinema'])->name('cinemas.edit');
    Route::put('/cinemas/{cinema}', [AdminController::class, 'updateCinema'])->name('cinemas.update');
    Route::delete('/cinemas/{cinema}', [AdminController::class, 'deleteCinema'])->name('cinemas.destroy');
    
    // Halls Management (Nested under Cinemas or standalone)
    Route::post('/halls', [AdminController::class, 'storeHall'])->name('halls.store');
    Route::put('/halls/{hall}', [AdminController::class, 'updateHall'])->name('halls.update');
    Route::delete('/halls/{hall}', [AdminController::class, 'deleteHall'])->name('halls.destroy');
    Route::get('/api/cinemas/{cinema}/halls', [AdminController::class, 'getHallsByCinema'])->name('api.cinemas.halls');
    Route::get('/api/halls/{hall}/showtimes', [AdminController::class, 'getShowtimesByHall'])->name('api.halls.showtimes');
    
    // Bookings Management
    Route::get('/bookings', [AdminController::class, 'bookingsList'])->name('bookings.index');
    Route::patch('/bookings/{booking}/status', [AdminController::class, 'updateBookingStatus'])->name('bookings.update-status');
});
