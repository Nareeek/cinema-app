@extends('layouts.app')

@section('title', 'Seat Booking')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/seat-booking.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/seat-booking.js') }}" defer></script>
@endpush

@section('content')
    <h1>Seat Booking</h1>

    <!-- Seat Grid -->
    <div id="seat-grid"></div>

    <!-- Booking Summary -->
    <div id="booking-summary">
        <h2>Booking Summary</h2>
        <p>Selected Seats: <span id="selected-seats"></span></p>
        <p>Total Price: $<span id="total-price">0.00</span></p>
        <button id="confirm-booking">Confirm Booking</button>
    </div>
@endsection

