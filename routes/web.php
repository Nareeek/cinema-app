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

Route::get('/', function () {
    $movies = Movie::all();
    $rooms = Room::all(); // Fetch all rooms
    return view('welcome', compact('movies', 'rooms'));
});

Route::get('/rooms/{id}/schedule', [RoomController::class, 'schedule']);

Route::view('/rooms', 'rooms.index');

// Route::view('/movies/{id}', 'movies.show')->where('id', '[0-9]+');
Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.details');
Route::get('/movies/{id}/schedule', [MovieController::class, 'getSchedules']);

// Route::view('/bookings/{id}', 'bookings.index')->where('id', '[0-9]+');

Route::view('/schedules', 'schedules.index');
Route::get('/schedules/{scheduleId}/seats', [SeatController::class, 'getSeatAvailability']);

Route::get('/payment', [PaymentController::class, 'paymentPage'])->name('payment.page');
// Route::get('/payment', [PaymentController::class, 'paymentPage'])->name('payment');
Route::post('/api/confirm-booking', [BookingController::class, 'confirmBooking']);

Route::view('/bookings/success', 'bookings.success');
Route::get('/bookings/{id}', [BookingController::class, 'index'])->where('id', '[0-9]+');


Route::get('/api/slideshow-images', [SlideshowController::class, 'getSlideshowImages']);

// Admin Portal
Route::view('/admin/schedules', 'admin.schedules.index');
Route::view('/admin/rooms', 'admin.rooms.index');
Route::view('/admin/movies', 'admin.movies.index');