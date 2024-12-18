@extends('layouts.app')

@section('title', 'Movie Details')

@section('content')
    <h1>Movie Details</h1>
    <div id="movie-details"></div>

    <script>
        const movieId = {{ $id }};
        fetch(`/api/movies/${movieId}`)
            .then(response => response.json())
            .then(movie => {
                const movieDetails = document.getElementById('movie-details');
                movieDetails.innerHTML = `
                    <h2>${movie.title}</h2>
                    <p>${movie.description}</p>
                    <img src="${movie.poster_url}" alt="Poster for ${movie.title}">
                    <h3>Available Schedules</h3>
                    <ul>
                        ${movie.schedules.map(schedule => `
                            <li>
                                ${schedule.schedule_time} - ${schedule.room.name}
                                <button onclick="book(${schedule.id})">Book</button>
                            </li>
                        `).join('')}
                    </ul>
                `;
            });

        function book(scheduleId) {
            window.location.href = `/bookings/${scheduleId}`;
        }
    </script>
@endsection
