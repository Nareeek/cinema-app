<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Room;
use App\Models\Schedule;

class BookingController extends Controller
{
    public function index($id)
    {
        // Fetch schedule details using the provided ID
        $schedule = Schedule::with(['movie', 'room'])->findOrFail($id);
        // $schedule = Schedule::findOrFail($id);
        $room = $schedule->room; // Ensure Room relation is defined in Schedule model
        $movie = $schedule->movie; // Ensure Movie relation is defined in Schedule model

        // Pass data to the view
        return view('bookings.index', compact('movie', 'room', 'schedule'));
    }
}
