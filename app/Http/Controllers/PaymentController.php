<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seat;
use App\Models\Schedule;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    // Display the Payment Page (GET Request)
    public function showPaymentPage(Request $request)
    {
        // Log::info('Accessed Payment Page (GET)', session()->all()); // Debug session data
    
        $scheduleId = session('scheduleId');
        $selectedSeats = session('selectedSeats', []);
        $totalPrice = session('totalPrice', 0);
    
        if (!$scheduleId || empty($selectedSeats)) {
            // Log::warning('Invalid session data. Redirecting to home.');
            return redirect('/')->withErrors(['error' => 'Invalid access. Please start again.']);
        }
    
        return view('payment.index', compact('selectedSeats', 'scheduleId', 'totalPrice'));
    }
    

    // Process Booking Data and Redirect to Payment Page (POST Request)
    public function processBookingData(Request $request)
    {
        Log::info('Processing Booking Data for Payment', $request->all()); // Debug request data
    
        // Validate incoming data
        $validated = $request->validate([
            'schedule_id' => 'required|integer',
            'selected_seats' => 'required|array|min:1',
            'total_price' => 'required|numeric|min:0',
        ]);
    
        // Save data to session
        session([
            'scheduleId' => $validated['schedule_id'],
            'selectedSeats' => $validated['selected_seats'],
            'totalPrice' => $validated['total_price'],
        ]);
    
        // Log::info('Session Data Saved', session()->all()); // Debug session data
    
        // Redirect to payment page
        return redirect()->route('payment.show');
    }    

    // Process Payment (Final Step)
    public function processPayment(Request $request)
    {
        // Log::info('Processing Payment', $request->all()); // Debug request payload
    
        $validated = $request->validate([
            'payment_method' => 'required|string',
        ]);
    
        $scheduleId = session('scheduleId');
        $selectedSeats = session('selectedSeats', []);
        $totalPrice = session('totalPrice', 0);
    
        if (!$scheduleId || empty($selectedSeats)) {
            // Log::error('Invalid session data during payment processing.');
            return redirect('/')->withErrors(['error' => 'Invalid session data. Please start again.']);
        }
    
        // Process payment logic
        foreach ($selectedSeats as $seat) {
            // Log::info('Marking seat as booked:', $seat);
            Seat::where('id', $seat['id'])->update(['is_booked' => true]);
        }
    
        session()->forget(['scheduleId', 'selectedSeats', 'totalPrice']);
        return redirect()->route('payment.success');
    }
    
}
