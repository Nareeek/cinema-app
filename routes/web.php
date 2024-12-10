<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SlideshowController;

Route::get('/', function () {
    return view('welcome');
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