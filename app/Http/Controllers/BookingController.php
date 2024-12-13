<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Room;
use App\Models\Seat;
use App\Models\Schedule;

class BookingController extends Controller
{
    public function index($id)
    {
        $schedule = Schedule::findOrFail($id);
        $room = $schedule->room; // Ensure Room relation exists
        $movie = $schedule->movie; // Ensure Movie relation exists
    
        return view('bookings.index', compact('movie', 'room', 'schedule'));
    }

    public function confirmBooking(Request $request) {
        $selectedSeats = $request->input('selected_seats', []);
        $scheduleId = $request->input('schedule_id');
    
        foreach ($selectedSeats as $seatId) {
            Seat::where('id', $seatId)->update(['is_booked' => 1]);
        }
    
        return response()->json(['success' => true]);
    }
    
}
