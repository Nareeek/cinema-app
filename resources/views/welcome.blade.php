@extends('layouts.app')

@section('title', 'Cinema App - Home')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/home.js') }}" defer></script>
@endpush

@section('content')
<div class="container">
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="logo">
            <img src="{{ asset('images/logo.jpg') }}" alt="Cinema App Logo", height="40", width="50">
        </div>
        <div class="language-selector">
            <button onclick="changeLanguage('en')">EN</button>
            <button onclick="changeLanguage('es')">ES</button>
            <button onclick="changeLanguage('fr')">FR</button>
        </div>
    </div>
    <!-- Top Section: Movie Slideshow -->
    <div class="slideshow">
        @foreach($movies as $movie)
            <div class="slide"> <!-- Add 'slide' class -->
                <img src="{{ asset('images/' . $movie->poster_url) }}" 
                    alt="{{ $movie->title }}" 
                    class="movie-image" 
                    data-movie-id="{{ $movie->id }}">
            </div>
        @endforeach
    </div>

    <!-- Middle Section: Rooms List -->
    <!-- Available Rooms Section -->
    <h2>Available Rooms</h2>
    <div class="room-container">
        @foreach ($rooms as $room)
        <div class="room-card" onclick="toggleSchedule({{ $room->id }})">
            <img src="{{ $room->image_url ? asset('images/' . $room->image_url) : asset('images/default-room-image.jpg') }}" 
                alt="{{ $room->name }}">
            <h3>{{ $room->name }}</h3>

            <!-- Collapsible Section for Schedule -->
            <div id="schedule-{{ $room->id }}" class="schedule-section" style="display: none;">
                <div class="filter-section">
                    <button class="filter-btn active" onclick="filterSchedule(event, {{ $room->id }}, 'today')">Today</button>
                    <button class="filter-btn" onclick="filterSchedule(event, {{ $room->id }}, 'tomorrow')">Tomorrow</button>
                </div>
                <table class="schedule-table">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Movie Name</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody id="schedule-body-{{ $room->id }}">
                        <!-- Placeholder content; dynamically updated with JavaScript -->
                        <tr>
                            <td colspan="3" class="loading-text">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    </div>
    <div id="room-schedule" style="margin-top: 20px;"></div>
</div>
@endsection
