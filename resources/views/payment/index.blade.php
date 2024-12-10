@extends('layouts.app')

@section('title', 'Payment Page')

@section('content')
    <h1>Payment Page</h1>

    <!-- Booking Summary -->
    <div id="booking-summary">
        <h2>Booking Summary</h2>
        <p>Selected Seats: <span id="selected-seats"></span></p>
        <p>Total Price: $<span id="total-price">0.00</span></p>
    </div>

    <!-- Payment Methods -->
    <div id="payment-methods">
        <h2>Select Payment Method</h2>
        <form id="payment-form">
            <label>
                <input type="radio" name="payment_method" value="credit_card" required>
                Credit Card
            </label><br>
            <label>
                <input type="radio" name="payment_method" value="paypal">
                PayPal
            </label><br>
            <label>
                <input type="radio" name="payment_method" value="cash">
                Cash
            </label><br>
            <button type="submit">Confirm Payment</button>
        </form>
    </div>

    <script>
        // Mock Data: Replace with actual booking details
        const selectedSeats = ['R1-S1', 'R1-S2'];
        const totalPrice = 20.00;

        // Populate booking summary
        document.getElementById('selected-seats').textContent = selectedSeats.join(', ');
        document.getElementById('total-price').textContent = totalPrice.toFixed(2);

        // Handle Payment Submission
        document.getElementById('payment-form').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const paymentMethod = formData.get('payment_method');

            // Simulate payment processing
            alert(`Payment successful using ${paymentMethod}!`);
            window.location.href = '/bookings/success'; // Redirect to success page
        });
    </script>

    <style>
        #payment-methods {
            margin-top: 20px;
        }
        #payment-form {
            margin-top: 10px;
        }
    </style>
@endsection
