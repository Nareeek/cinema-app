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
        @foreach($rooms as $room)
        <div class="room-card" data-room-id="{{ $room->id }}" onclick="showRoomSchedule(this)">
            <img src="{{ $room->image_url ? asset('images/' . $room->image_url) : asset('images/default-room-image.jpg') }}" 
                alt="{{ $room->name }}"
                data-room-id="{{ $room->id }}">
            <h3>{{ $room->name }}</h3>
        </div>
        @endforeach
    </div>
    <div id="room-schedule" style="margin-top: 20px;"></div>
</div>
@endsection
