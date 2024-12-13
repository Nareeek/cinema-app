<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seat;

class PaymentController extends Controller
{
    // Add this to your PaymentController or relevant route logic
    public function confirmBooking(Request $request)
    {
        $selectedSeats = $request->input('selected_seats', []);
        $scheduleId = $request->input('schedule_id');
        $paymentMethod = $request->input('payment_method');
    
        if (empty($selectedSeats) || !$scheduleId || !$paymentMethod) {
            return response()->json(['success' => false, 'message' => 'Invalid data'], 400);
        }
    
        // Mark seats as booked
        foreach ($selectedSeats as $seatId) {
            Seat::where('id', $seatId)->update(['is_booked' => 1]);
        }
    
        return response()->json(['success' => true]);
    }

    public function paymentPage(Request $request)
    {
        $selectedSeats = json_decode($request->input('selected_seats', '[]'), true); // Decode JSON to array
        $scheduleId = $request->input('schedule_id');
        $totalPrice = $request->input('total_price', 0);
    
        if (!is_array($selectedSeats)) {
            $selectedSeats = []; // Fallback in case decoding fails
        }
    
        // Debug the structure of $selectedSeats
        if (is_string($selectedSeats)) {
            $selectedSeats = json_decode($selectedSeats, true); // Handle JSON string
        }

        // Ensure $selectedSeats is an array of integers
        if (is_array($selectedSeats) && isset($selectedSeats[0]['id'])) {
            // Extract 'id' if the structure is [['id' => 2], ['id' => 3]]
            $selectedSeats = array_column($selectedSeats, 'id');
        }

        $detailedSeats = array_map(function ($seatId) {
            return [
                'id' => $seatId,
                'row' => ceil($seatId / 10), // Example logic for rows
                'number' => $seatId % 10 ?: 10, // Example logic for seat numbers
            ];
        }, $selectedSeats);

        // Fetch seats directly from the database
        $detailedSeats = Seat::whereIn('id', $selectedSeats)
            ->get(['id', 'row_number', 'seat_number'])
            ->toArray();

        return view('payment.index', [
            'scheduleId' => $scheduleId,
            'selectedSeats' => $detailedSeats,
            'totalPrice' => $totalPrice,
        ]);
    }
}
