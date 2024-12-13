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
        $schedule = Schedule::findOrFail($id);
        $room = $schedule->room; // Ensure Room relation exists
        $movie = $schedule->movie; // Ensure Movie relation exists
        // dd($schedule);
    
        return view('bookings.index', compact('movie', 'room', 'schedule'));
    }
}
