<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Schedule;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    // Check seat availability
    public function availability($id)
    {
        $schedule = Schedule::with('room.seats')->findOrFail($id);
        $bookedSeats = Booking::where('schedule_id', $id)->pluck('seat_id');

        $seats = $schedule->room->seats->map(function ($seat) use ($bookedSeats) {
            $seat->is_booked = $bookedSeats->contains($seat->id);
            return $seat;
        });

        return response()->json($seats);
    }

    // Book a seat
    public function book(Request $request, $id)
    {
        $validated = $request->validate([
            'seat_id' => 'required|exists:seats,id',
            'user_email' => 'required|email',
            'user_phone' => 'required|string',
        ]);

        $seatAlreadyBooked = Booking::where('schedule_id', $id)
            ->where('seat_id', $validated['seat_id'])
            ->exists();

        if ($seatAlreadyBooked) {
            return response()->json(['error' => 'Seat already booked'], 400);
        }

        $booking = Booking::create([
            'schedule_id' => $id,
            'seat_id' => $validated['seat_id'],
            'user_email' => $validated['user_email'],
            'user_phone' => $validated['user_phone'],
            'status' => 'Confirmed',
        ]);

        return response()->json($booking, 201);
    }
}
