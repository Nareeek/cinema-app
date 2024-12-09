@extends('layouts.app')

@section('title', 'Movie Management')

@section('content')
    <h1>Movie Management</h1>
    <button onclick="showMovieForm()">Add New Movie</button>
    <div id="movie-form" style="display: none;">
        <form id="movie-form-data">
            <input type="hidden" id="movie-id">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required><br>

            <label for="description">Description:</label>
            <textarea id="description" name="description"></textarea><br>

            <label for="poster_url">Poster URL:</label>
            <input type="url" id="poster_url" name="poster_url" required><br>

            <label for="trailer_url">Trailer URL:</label>
            <input type="url" id="trailer_url" name="trailer_url"><br>

            <label for="duration">Duration (minutes):</label>
            <input type="number" id="duration" name="duration" required><br>

            <button type="submit">Save Movie</button>
            <button type="button" onclick="hideMovieForm()">Cancel</button>
        </form>
    </div>
    <div id="movies"></div>

    <script>
        // Fetch and display all movies
        function fetchMovies() {
            fetch('/api/admin/movies')
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('movies');
                    container.innerHTML = ''; // Clear previous content
                    data.forEach(movie => {
                        const div = document.createElement('div');
                        div.innerHTML = `
                            <h2>${movie.title}</h2>
                            <p>Description: ${movie.description || 'No description'}</p>
                            <p>Duration: ${movie.duration} minutes</p>
                            <img src="${movie.poster_url}" alt="Poster for ${movie.title}" style="width: 150px;">
                            <button onclick="editMovie(${movie.id})">Edit</button>
                            <button onclick="deleteMovie(${movie.id})">Delete</button>
                        `;
                        container.appendChild(div);
                    });
                });
        }

        fetchMovies();

        // Show the movie form
        function showMovieForm(movie = null) {
            const form = document.getElementById('movie-form');
            form.style.display = 'block';

            // If editing, populate form fields
            if (movie) {
                document.getElementById('movie-id').value = movie.id;
                document.getElementById('title').value = movie.title;
                document.getElementById('description').value = movie.description;
                document.getElementById('poster_url').value = movie.poster_url;
                document.getElementById('trailer_url').value = movie.trailer_url;
                document.getElementById('duration').value = movie.duration;
            } else {
                document.getElementById('movie-form-data').reset();
                document.getElementById('movie-id').value = '';
            }
        }

        // Hide the movie form
        function hideMovieForm() {
            document.getElementById('movie-form').style.display = 'none';
        }

        // Save (Create or Update) a movie
        document.getElementById('movie-form-data').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());
            const movieId = document.getElementById('movie-id').value;

            const method = movieId ? 'PUT' : 'POST';
            const endpoint = movieId ? `/api/admin/movies/${movieId}` : '/api/admin/movies';

            fetch(endpoint, {
                method: method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data),
            })
                .then(() => {
                    fetchMovies(); // Refresh movie list
                    hideMovieForm();
                });
        });

        // Edit a movie
        function editMovie(id) {
            fetch(`/api/admin/movies/${id}`)
                .then(response => response.json())
                .then(movie => {
                    showMovieForm(movie);
                });
        }

        // Delete a movie
        function deleteMovie(id) {
            fetch(`/api/admin/movies/${id}`, { method: 'DELETE' })
                .then(() => fetchMovies());
        }
    </script>
@endsection
