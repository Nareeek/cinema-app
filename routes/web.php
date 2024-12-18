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

Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.details');
Route::get('/movies/{id}/schedule', [MovieController::class, 'getSchedules']);
Route::get('/movies/{movie}/rooms', [MovieController::class, 'getRoomsByDate']);


Route::post('/check-seats', [BookingController::class, 'checkSeatAvailability'])->name('checkSeats');
Route::post('/check-seats-before-payment', [PaymentController::class, 'checkSeatsBeforePayment'])->name('checkSeatsBeforePayment');


Route::get('/rooms', [RoomController::class, 'index']);
Route::get('/rooms/{id}/schedule', [RoomController::class, 'schedule']);

Route::get('/bookings/{id}', [BookingController::class, 'index'])->where('id', '[0-9]+');
Route::post('/api/confirm-booking', [BookingController::class, 'confirmBooking']);
Route::view('/bookings/success', 'bookings.success')->name('bookings.success');

Route::get('/api/schedules/{scheduleId}/seats', [SeatController::class, 'getSeatAvailability']);
Route::post('/api/schedules/{id}/book', [SeatController::class, 'book']);

Route::post('/payment', [PaymentController::class, 'processBookingData'])->name('payment.page');
Route::get('/payment', [PaymentController::class, 'showPaymentPage'])->name('payment.show');
Route::post('/payment/process', [PaymentController::class, 'processPayment'])->name('payment.process');

// Slideshow images route
Route::get('/api/slideshow-images', [SlideshowController::class, 'getSlideshowImages']);

// Admin routes
Route::view('/admin/schedules', 'admin.schedules.index');
Route::view('/admin/rooms', 'admin.rooms.index');
Route::view('/admin/movies', 'admin.movies.index');

Route::get('/api/admin/movies', [MovieController::class, 'index']);
Route::post('/api/admin/movies', [MovieController::class, 'store']);
Route::get('/api/admin/movies/{id}', [MovieController::class, 'show']);
Route::put('/api/admin/movies/{id}', [MovieController::class, 'update']);
Route::delete('/api/admin/movies/{id}', [MovieController::class, 'destroy']);

// Prevent Debugbar direct access in local environment
if (app()->environment('local')) {
    Route::get('/_debugbar/*', function () {
        abort(404);
    });
}
