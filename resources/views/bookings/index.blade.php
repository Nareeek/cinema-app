@extends('layouts.app')

@section('title', 'Seat Booking')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/seat-booking.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/seat-booking.js') }}" defer></script>
@endpush

@section('content')
<div class="container">
    <!-- Hidden Data for JavaScript -->
    <div id="booking-data" 
         data-schedule-id="{{ $schedule->id }}" 
         data-movie-id="{{ $movie->id }}" 
         data-room-id="{{ $room->id }}">
    </div>

    <!-- Info Header -->
    <div id="info-header" class="info-header">
        <div class="info-row">
            <span class="movie-title">{{ $movie->title }}</span>
            <span class="movie-room">Room: {{ $room->name }}</span>
            <span class="movie-datetime">
                {{ \Carbon\Carbon::parse($schedule->schedule_time)->format('M d, Y h:i A') }}
            </span>
        </div>
    </div>

    <!-- Seats Table Section -->
    <div id="seat-container" class="seat-container">
        <div id="seat-header" class="seat-header"></div>
        <div id="seat-grid" class="seat-grid"></div>
    </div>

    <!-- Summary Section -->
    <div id="booking-summary" class="summary-section">
        <h3>Booking Summary</h3>
        <table>
            <thead>
                <tr>
                    <th>Row</th>
                    <th>Seat</th>
                    <th>Price</th>
                    <th>Clear</th>
                </tr>
            </thead>
            <tbody id="summary-table"></tbody>
        </table>
        <p>Total Price: <span id="total-price">$0.00</span></p>
    </div>

    <!-- Email and Phone Section -->
    <div id="email-phone-section" class="contact-section">
        <h3>Contact Information</h3>
        <label for="email">Email:</label>
        <input type="email" id="email" placeholder="Enter your email" required>
        <label for="phone">Phone:</label>
        <input type="text" id="phone" placeholder="Enter your phone number" required>
        <button id="continue-btn" class="booking-btn" disabled>Continue to Payment</button>
    </div>
</div>
@endsection
