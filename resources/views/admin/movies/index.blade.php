@extends('layouts.app')

@section('title', 'Movie Management')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/movies.css') }}">
@endpush

@push('scripts')
<script type="module" src="{{ asset('js/admin/movies/main.js') }}" defer></script>
@endpush

@section('content')
<div class="container">
    <h1>🎥 Movie Management</h1>

    <!-- Add Movie Button -->
    <button class="btn-add-movie" onclick="toggleMovieCard()">➕ Add New Movie</button>
    <div id="loading-overlay">Processing...</div>


    <!-- Add Movie Card -->
    <div id="add-movie-card" class="popup movie-card hidden">
        <h2 id="popup-title">Add New Movie</h2>
        <button class="close-popup-btn" onclick="toggleMovieCard()">✖</button>
        <form id="add-movie-form">
            <img id="poster-preview" style="display: none; max-width: 100%; margin-top: 10px;" alt="Poster Preview">
            <input type="text" id="poster_url" name="poster_url" placeholder="Poster URL" required>
            <input type="text" id="title" name="title" placeholder="Movie Title" required>
            <textarea id="description" name="description" placeholder="Description"></textarea>
            <input type="text" id="trailer_url" name="trailer_url" placeholder="Trailer URL">
            <input type="number" id="duration" name="duration" placeholder="Duration (minutes)" required>
            <button type="submit" class="btn-submit">Add Movie</button>
        </form>
    </div>

    <!-- Movie Table -->
    <h2>Existing Movies</h2>
    <table class="movie-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Duration</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="movies-table-body"></tbody>
    </table>
    <button id="view-more" style="display: none;">View More</button>
</div>
@endsection

