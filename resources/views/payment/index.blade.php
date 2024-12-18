@extends('layouts.app')

@section('title', 'Payment Page')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/payment.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/payment.js') }}" defer></script>
@endpush

@section('content')
<div id="payment-data"
     data-schedule-id="{{ $scheduleId }}"
     data-selected-seats="{{ json_encode($selectedSeats ?? []) }}"
     data-total-price="{{ $totalPrice ?? 0 }}">
</div>
<div class="payment-container">
    <h1 class="payment-title">Complete Your Payment</h1>
    <div id="booking-summary" class="summary-section">
        <h2>Booking Summary</h2>
        <p><strong>Seats:</strong> <span id="selected-seats">Loading...</span></p>
        <p><strong>Total:</strong> <span id="total-price">$0.00</span></p>
    </div>
    <div id="payment-methods" class="payment-methods-section">
        <div class="payment-method" data-method="credit_card">Credit Card</div>
        <div class="payment-method" data-method="paypal">PayPal</div>
        <div class="payment-method" data-method="cash">Cash</div>
    </div>
    <button id="confirm-payment-btn" class="confirm-payment-btn" disabled>Pay Now</button>
</div>
@endsection
