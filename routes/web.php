<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SlideshowController;
use App\Models\Movie;
use App\Models\Room;

Route::get('/', function () {
    $movies = Movie::all();
    $rooms = Room::all(); // Fetch all rooms
    return view('welcome', compact('movies', 'rooms'));
});

Route::view('/rooms', 'rooms.index');

Route::view('/movies/{id}', 'movies.show')->where('id', '[0-9]+');

Route::view('/bookings/{id}', 'bookings.index')->where('id', '[0-9]+');

Route::view('/schedules', 'schedules.index');

Route::view('/payment', 'payment.index');

Route::view('/bookings/success', 'bookings.success');

Route::get('/api/slideshow-images', [SlideshowController::class, 'getSlideshowImages']);

// Admin Portal
Route::view('/admin/schedules', 'admin.schedules.index');
Route::view('/admin/rooms', 'admin.rooms.index');
Route::view('/admin/movies', 'admin.movies.index');