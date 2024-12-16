<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Seat;
use App\Models\Schedule;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    // Check seat availability for a schedule
    public function availability($id)
    {
        $seats = Seat::where('room_id', function ($query) use ($id) {
            $query->select('room_id')->from('schedules')->where('id', $id)->limit(1);
        })->get();
    
        $bookedSeats = Booking::where('schedule_id', $id)->pluck('seat_id')->toArray();
    
        $seats->each(function ($seat) use ($bookedSeats) {
            $seat->is_booked = in_array($seat->id, $bookedSeats);
            $seat->price = $seat->price; // Include the price
        });
    
        return response()->json($seats);
    }

    // Book a seat
    public function book(Request $request, $id)
    {
        $validated = $request->validate([
            'seat_id' => 'required|exists:seats,id',
            'user_email' => 'required|email',
            'user_phone' => 'required|string|min:10',
            'status' => 'required|string|in:Pending,Confirmed',
        ]);

        // Ensure the schedule exists
        $schedule = Schedule::findOrFail($id);

        // Check if the seat is already booked for this schedule
        $isSeatBooked = Booking::where('schedule_id', $id)
            ->where('seat_id', $request->seat_id)
            ->exists();

        if ($isSeatBooked) {
            return response()->json(['error' => 'This seat is already booked for this schedule.'], 422);
        }

        // Create the booking
        $booking = Booking::create([
            'schedule_id' => $id,
            'seat_id' => $request->seat_id,
            'user_email' => $validated['user_email'],
            'user_phone' => $validated['user_phone'],
            'status' => $validated['status'],
        ]);

        return response()->json($booking, 201);
    }

    // Fetch seat availability for a specific schedule
    public function getSeatAvailability($scheduleId)
    {
        $seats = Seat::where('schedule_id', $scheduleId)->get();
    
        return response()->json($seats);
    }
}
