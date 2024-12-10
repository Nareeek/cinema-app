@extends('layouts.app')

@section('title', 'Movie Management')

@section('content')
    <h1>Movie Management</h1>

    <!-- Add Movie Form -->
    <form id="add-movie-form" enctype="multipart/form-data">
        <h2>Add New Movie</h2>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea><br>

        <label for="poster_url">Poster (URL):</label>
        <input type="text" id="poster_url" name="poster_url"><br>

        <label for="trailer_url">Trailer (URL):</label>
        <input type="text" id="trailer_url" name="trailer_url"><br>

        <label for="duration">Duration (minutes):</label>
        <input type="number" id="duration" name="duration" required><br>

        <button type="submit">Add Movie</button>
    </form>

    <!-- Movies Table -->
    <h2>Existing Movies</h2>
    <table id="movies-table" border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Duration</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <script>
        // Fetch and display movies
        function loadMovies() {
            fetch('/api/admin/movies')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.querySelector('#movies-table tbody');
                    tableBody.innerHTML = ''; // Clear table
                    data.forEach(movie => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${movie.id}</td>
                            <td>${movie.title}</td>
                            <td>${movie.description || 'N/A'}</td>
                            <td>${movie.duration} min</td>
                            <td>
                                <button onclick="deleteMovie(${movie.id})">Delete</button>
                                <button onclick="editMovie(${movie.id})">Edit</button>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });
                });
        }

        // Handle form submission for adding a new movie
        document.getElementById('add-movie-form').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());

            fetch('/api/admin/movies', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data),
            })
                .then(response => {
                    if (response.ok) {
                        alert('Movie added successfully!');
                        loadMovies(); // Refresh table
                        this.reset(); // Reset form
                    } else {
                        alert('Failed to add movie.');
                    }
                });
        });

        // Delete a movie
        function deleteMovie(id) {
            fetch(`/api/admin/movies/${id}`, {
                method: 'DELETE',
            })
                .then(response => {
                    if (response.ok) {
                        alert('Movie deleted successfully!');
                        loadMovies(); // Refresh table
                    } else {
                        alert('Failed to delete movie.');
                    }
                });
        }

        // Placeholder for edit movie logic (can be implemented later)
        function editMovie(id) {
            alert(`Edit functionality for Movie ID ${id} will be implemented later.`);
        }

        // Initialize page
        loadMovies();
    </script>
@endsection
