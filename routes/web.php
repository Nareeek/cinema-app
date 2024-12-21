<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SlideshowController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SeatController;
use App\Models\Movie;
use App\Models\Room;

// Root route for homepage
Route::get('/', function () {
    $movies = Movie::all();
    $rooms = Room::all(); // Fetch all rooms
    if (!view()->exists('welcome')) {
        abort(404, 'The welcome view is missing.');
    }
    return view('welcome', compact('movies', 'rooms'));
})->name('home');

// Movie-related routes
Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.details');
Route::get('/movies/{id}/schedule', [MovieController::class, 'getSchedules']);
Route::get('/movies/{movie}/rooms', [MovieController::class, 'getRoomsByDate']);

// Booking-related routes
Route::post('/check-seats', [BookingController::class, 'checkSeatAvailability'])->name('checkSeats');
Route::post('/check-seats-before-payment', [PaymentController::class, 'checkSeatsBeforePayment'])->name('checkSeatsBeforePayment');
Route::get('/bookings/{id}', [BookingController::class, 'index'])->where('id', '[0-9]+');
Route::post('/api/confirm-booking', [BookingController::class, 'confirmBooking']);
Route::view('/bookings/success', 'bookings.success')->name('bookings.success');

// Room-related routes
Route::get('/rooms', [RoomController::class, 'index']);
Route::get('/rooms/{id}/schedule', [RoomController::class, 'schedule']);

// Seat-related routes
Route::get('/api/schedules/{scheduleId}/seats', [SeatController::class, 'getSeatAvailability']);
Route::post('/api/schedules/{id}/book', [SeatController::class, 'book']);

// Payment-related routes
Route::post('/payment', [PaymentController::class, 'processBookingData'])->name('payment.page');
Route::get('/payment', [PaymentController::class, 'showPaymentPage'])->name('payment.show');
Route::post('/payment/process', [PaymentController::class, 'processPayment'])->name('payment.process');

// Slideshow images route
Route::get('/api/slideshow-images', [SlideshowController::class, 'getSlideshowImages']);

// Admin routes
Route::get('/admin/movies', [MovieController::class, 'moviesPage'])->name('admin.movies.page');

// Prevent Debugbar direct access in local environment
if (app()->environment('local')) {
    Route::get('/_debugbar/*', function () {
        abort(404);
    });
}
