@extends('layouts.app')

@section('title', 'Payment Page')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/payment.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/payment.js') }}" defer></script>
@endpush

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
@endsection
