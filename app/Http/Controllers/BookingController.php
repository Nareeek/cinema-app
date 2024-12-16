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
        // Retrieve schedule
        $schedule = Schedule::findOrFail($id);
    
        // Retrieve related data
        $movie = Movie::findOrFail($schedule->movie_id);
        $room = Room::findOrFail($schedule->room_id);
    
        // Pass all required variables to the view
        return view('bookings.index', [
            'schedule' => $schedule,
            'movie' => $movie,
            'room' => $room,
        ]);
    }
    public function confirmBooking(Request $request) {
        try {
            $selectedSeats = $request->input('selected_seats', []);
            $scheduleId = $request->input('schedule_id');
            $paymentMethod = $request->input('payment_method');
        
            if (empty($selectedSeats) || !$scheduleId || !$paymentMethod) {
                return response()->json(['success' => false, 'message' => 'Invalid input data'], 400);
            }
        
            foreach ($selectedSeats as $seatData) {
                if (isset($seatData['id'])) {
                    $seat = Seat::find($seatData['id']);
                    if ($seat) {
                        // \Log::info("Marking seat as booked: Seat ID - {$seatData['id']}");
                        $seat->update(['is_booked' => true]);
                        // \Log::info("Seat update query executed for ID: " . $seatData['id']);
                    } else {
                        \Log::warning("Seat not found: " . $seatData['id']);
                    }
                } else {
                    // \Log::warning("Invalid seat data: " . json_encode($seatData));
                    \Log::warning("Seat not found for update: " . $seatData['id']);
                }
            }
        
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // \Log::error("Error confirming booking: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while processing your request.'], 500);
        }
    }
    
}
