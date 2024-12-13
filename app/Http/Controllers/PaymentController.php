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
    
        foreach ($selectedSeats as $seat) {
            // Mark seat as booked
            Seat::where('id', $seat['id'])->update(['is_booked' => true]);
        }
    
        dd($selectedSeats);
        return response()->json(['success' => true]);
    }

    public function paymentPage(Request $request)
    {
        $selectedSeats = $request->input('selected_seats', []);
        $totalPrice = $request->input('total_price', 0);

        return view('payment.index', compact('selectedSeats', 'totalPrice'));
    }
    
}
