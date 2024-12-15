@extends('layouts.app')

@section('title', $movie->title)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/movie-details.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/movie-details.js') }}" defer></script>
@endpush

@section('content')
<div class="movie-details">
    <!-- Movie Header -->
    <div class="movie-header">
        <img src="{{ asset('posters/' . $movie->poster_url) }}" alt="{{ $movie->title }}">
        <div class="movie-header-content">
            <h1 class="movie-title">{{ $movie->title }}</h1>
            <p class="movie-description">{{ $movie->description }}</p>
            <p class="movie-info"><strong>Duration:</strong> {{ $movie->duration }} mins</p>
            <p class="movie-info"><a href="{{ $movie->trailer_url }}" target="_blank">Watch Trailer</a></p>
        </div>
    </div>

    <!-- Hidden input for movie ID -->
    <input type="hidden" id="movie-id" value="{{ $movie->id }}">

    <!-- Schedule Section -->
    <div class="schedule-section">
        <h2>Schedule</h2>
        <div class="filter-section">
            <button class="filter-btn active" data-day="today" onclick="filterSchedule('today')">Today</button>
            <button class="filter-btn" data-day="tomorrow" onclick="filterSchedule('tomorrow')">Tomorrow</button>
        </div>
        <table class="schedule-table">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Room</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="schedule-body">
                <tr>
                    <td colspan="4" class="loading-text">Loading...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
