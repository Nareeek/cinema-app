@extends('layouts.app')

@section('title', 'Home | Cinema App')

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
            <img src="{{ asset('images/logo.jpg') }}" alt="Cinema App Logo">
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
            <div>
                <img src="{{ asset('images/' . $movie->poster_url) }}" alt="{{ $movie->title }}" class="movie-image">
            </div>
        @endforeach
    </div>

    <!-- Middle Section: Rooms List -->
    <!-- Available Rooms Section -->
    <h2>Available Rooms</h2>
    <div class="rooms-section">
        @foreach($rooms as $room)
            <div class="room-card" data-room-id="{{ $room->id }}" onclick="showRoomSchedule(this)">
                <img src="{{ asset('images/' . $room->image_url) }}" alt="{{ $room->name }}" class="room-image">
                <h3>{{ $room->name }}</h3>
            </div>
        @endforeach
    </div>

    <!-- Room Schedule Section -->
    <div id="room-schedule" class="room-schedule">
        <!-- Dynamic Room Schedule will be displayed here -->
    </div>
</div>
@endsection
