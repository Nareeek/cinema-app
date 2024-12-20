// Fetch movies with pagination
function fetchMovies(page) {
    return fetch(`/api/admin/movies?page=${page}`, {
        headers: { "Accept": "application/json" },
    })
        .then((response) => {
            if (!response.ok) {
                return response.text().then((text) => {
                    throw new Error(`Error response: ${text}`);
                });
            }
            return response.json(); // Parse the JSON response
        });
}

// Fetch details of a specific movie
function fetchMovieDetails(id) {
    return fetch(`/api/admin/movies/${id}`, {
        headers: { "Accept": "application/json" },
    })
    .then((response) => {
        console.log("API response for movie details:", response);
        if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
        return response.json();
    });
}

// Delete a movie by ID
function deleteMovieAPI(id) {
    return fetch(`/api/admin/movies/${id}`, {
        method: "DELETE",
        headers: { "Accept": "application/json" },
    }).then((response) => {
        if (!response.ok) {
            return response.json().then((error) => Promise.reject(error));
        }
        return response.json(); // Success response
    });
}

// Export API service functions
export { fetchMovies, fetchMovieDetails, deleteMovieAPI };
