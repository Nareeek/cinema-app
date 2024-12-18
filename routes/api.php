<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\Admin\ScheduleController;

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


// Room CRUD API routes
Route::prefix('admin')->group(function () {
    Route::get('/rooms', [RoomController::class, 'index']); // List rooms
    Route::post('/rooms', [RoomController::class, 'store']); // Create room
    Route::get('/rooms/{id}', [RoomController::class, 'show']); // Get room details
    Route::put('/rooms/{id}', [RoomController::class, 'update']); // Update room
    Route::delete('/rooms/{id}', [RoomController::class, 'destroy']); // Delete room
});

// Movie CRUD API routes
Route::prefix('admin')->group(function () {
    Route::get('/movies', [MovieController::class, 'index']); // List movies
    Route::post('/movies', [MovieController::class, 'store']); // Create movie
    Route::get('/movies/{id}', [MovieController::class, 'show']); // Get movie details
    Route::put('/movies/{id}', [MovieController::class, 'update']); // Update movie
    Route::delete('/movies/{id}', [MovieController::class, 'destroy']); // Delete movie
});

// Schedule CRUD API routes
Route::prefix('admin')->group(function () {
    Route::get('/schedules', [ScheduleController::class, 'index']); // List schedules
    Route::post('/schedules', [ScheduleController::class, 'store']); // Create schedule
    Route::get('/schedules/{id}', [ScheduleController::class, 'show']); // Get schedule details
    Route::put('/schedules/{id}', [ScheduleController::class, 'update']); // Update schedule
    Route::delete('/schedules/{id}', [ScheduleController::class, 'destroy']); // Delete schedule
});