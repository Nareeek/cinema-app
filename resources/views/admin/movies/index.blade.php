@extends('layouts.app')

@section('title', 'Movie Management')

@section('content')
    <h1>Movie Management</h1>
    <button onclick="createMovie()">Add New Movie</button>
    <div id="movies"></div>

    <script>
        // Fetch all movies and display them
        fetch('/api/admin/movies')
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('movies');
                data.forEach(movie => {
                    const div = document.createElement('div');
                    div.innerHTML = `
                        <h2>${movie.title}</h2>
                        <p>Description: ${movie.description || 'No description'}</p>
                        <p>Duration: ${movie.duration} minutes</p>
                        <img src="${movie.poster_url}" alt="${movie.title} Poster" style="width: 150px;">
                        <button onclick="editMovie(${movie.id})">Edit</button>
                        <button onclick="deleteMovie(${movie.id})">Delete</button>
                    `;
                    container.appendChild(div);
                });
            });

        function createMovie() {
            alert('Redirect to movie creation form');
        }

        function editMovie(id) {
            alert('Redirect to edit form for movie ' + id);
        }

        function deleteMovie(id) {
            alert('Delete movie with id ' + id);
        }
    </script>
@endsection
