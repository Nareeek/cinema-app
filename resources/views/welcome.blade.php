@extends('layouts.app')

@section('title', 'Home')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@push('scripts')
<script type="module" src="{{ asset('js/main.js') }}" defer></script>
<script type="module" src="{{ asset('js/home-slideshow.js') }}" defer></script>
@endpush

@section('content')
<div class="container">
    <!-- Top Section: Movie Slideshow -->
    <div class="slideshow">
        @foreach($movies as $movie)
            <div class="slide" data-id="{{ $movie->id }}">
                <img src="{{ asset($movie->poster_url) }}" 
                    alt="{{ $movie->title }}" 
                    class="movie-image">
                <div class="movie-title">{{ $movie->title }}</div>
            </div>
        @endforeach
    </div>

    <!-- Middle Section: Rooms List -->
    <h2>Available Rooms</h2>
    <div class="room-container">
        @foreach ($rooms as $room)
        <div class="room-card" data-room-id="{{ $room->id }}">
            <!-- Room Image and Name -->
            <img src="{{ $room->image_url ? asset('/storage/posters/' . $room->image_url) : asset('/storage/posters/default-room-image.jpg') }}" 
                alt="{{ $room->name }}">
            <h3>{{ $room->name }}</h3>

            <!-- Collapsible Section for Schedule -->
            <div id="schedule-{{ $room->id }}" class="schedule-section" style="display: none;">
                <div class="filter-section" data-room-id="{{ $room->id }}">
                    <!-- Filter Buttons -->
                    <button class="filter-btn" data-room-id="{{ $room->id }}" data-day="today">Today</button>
                    <button class="filter-btn" data-room-id="{{ $room->id }}" data-day="tomorrow">Tomorrow</button>
                    <input type="text" class="date-picker" placeholder="Pick a date" data-room-id="{{ $room->id }}">
                </div>

                <!-- Schedule Table -->
                <table class="schedule-table">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Movie Name</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody id="schedule-body-{{ $room->id }}">
                        <!-- Schedule rows will be loaded here dynamically -->
                    </tbody>
                </table>

                <!-- View More Button -->
                <button id="view-more-{{ $room->id }}" class="view-more-btn" data-room-id="{{ $room->id }}">View More</button>
            </div>
        </div>
        @endforeach
    </div>
    <div id="room-schedule" style="margin-top: 20px;"></div>
</div>
@endsection
