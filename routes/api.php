<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\SeatController;

/*
 |--------------------------------------------------------------------------
 | API Routes
 |--------------------------------------------------------------------------
 |
 | Here is where you can register API routes for your application. These
 | routes are loaded by the RouteServiceProvider within a group which
 | is assigned the "api" middleware group. Enjoy building your API!
 |
 */

// Example for user authentication route (default)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/rooms', [RoomController::class, 'index']); // List all rooms
Route::get('/rooms/{id}/schedules', [RoomController::class, 'schedules']); // Room schedules

Route::get('/movies', [MovieController::class, 'index']); // List all movies
Route::get('/movies/{id}', [MovieController::class, 'show']); // Movie details with schedules

Route::get('/schedules/{id}/seats', [SeatController::class, 'availability']); // Seat availability
Route::post('/schedules/{id}/book', [SeatController::class, 'book']); // Book a seat
