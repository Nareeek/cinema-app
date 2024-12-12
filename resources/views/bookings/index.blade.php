@extends('layouts.app')

@section('title', 'Seat Booking')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/seat-booking.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/seat-booking.js') }}" defer></script>
@endpush

@section('content')
<div class="booking-container">
    <!-- Header -->
    <div class="header">
        <h1>Seat Selection</h1>
        <div class="movie-details">
            <p>Movie: <span id="movie-title">{{ $movie->title }}</span></p>
            <p>Room: <span id="room-name">{{ $room->name }}</span></p>
            <p>Date & Time: <span id="schedule-time">{{ $schedule->date_time }}</span></p>
        </div>
    </div>

    <!-- Seat Grid -->
    <div id="seat-grid" class="seat-grid"></div>

    <!-- Booking Summary -->
    <div id="booking-summary" class="summary">
        <h2>Summary</h2>
        <table>
            <thead>
                <tr>
                    <th>Row</th>
                    <th>Seat</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="summary-table">
                <!-- Dynamically generated rows will go here -->
            </tbody>
        </table>
        <p>Total Price: $<span id="total-price">0.00</span></p>
    </div>

    <!-- User Information -->
    <div class="user-info">
        <label for="email">Email:</label>
        <input type="email" id="email" placeholder="Enter your email" required>
        <label for="phone">Phone:</label>
        <input type="text" id="phone" placeholder="Enter your phone number" required>
    </div>

    <!-- Continue Button -->
    <button id="continue-btn" class="btn" disabled>Continue</button>
</div>
@endsection
