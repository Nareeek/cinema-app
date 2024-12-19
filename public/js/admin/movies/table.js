import { toggleMovieCard, setPopupTitle } from "./formUtils.js";
import { showPosterPreview } from "./utils.js";
import { fetchMovies, fetchMovieDetails } from "./api.js";

let currentPage = 1; // Track the current page globally

// Load movies and handle rendering
function loadMovies(page = 1) {
    if (page === 1) currentPage = 1; // Reset currentPage on fresh load

    fetchMovies(page)
        .then((data) => {
            renderMovies(data, page); // Render the movies into the table
            handlePagination(data);   // Handle pagination ("View More" button)
        })
        .catch((error) => {
            console.error("Error loading movies:", error);
            alert("Failed to load movies.");
        });
}

// Render movies into the table
function renderMovies(data, page) {
    console.log("Movies data:", data);
    const tbody = document.getElementById("movies-table-body");

    // Clear the table for the first page
    if (page === 1) tbody.innerHTML = "";

    data.data.forEach((movie) => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${movie.id}</td>
            <td>${movie.title}</td>
            <td>${movie.duration} min</td>
            <td>
                <button class="btn-edit" onclick="editMovie(${movie.id})">✏ Edit</button>
                <button class="btn-delete" onclick="deleteMovie(${movie.id})">❌ Delete</button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

// Handle pagination for the movie table
function handlePagination(data) {
    const viewMoreButton = document.getElementById("view-more");

    if (!viewMoreButton) {
        console.warn("View More button not found in the DOM.");
        return; // Exit the function if the button is not present
    }

    // Remove any existing click listeners to prevent duplication
    viewMoreButton.replaceWith(viewMoreButton.cloneNode(true)); 
    const newViewMoreButton = document.getElementById("view-more");

    // Check if more pages are available
    if (data.next_page_url) {
        newViewMoreButton.style.display = "block";
        newViewMoreButton.addEventListener("click", () => {
            currentPage++;
            loadMovies(currentPage); // Load the next page of movies
        });
    } else {
        newViewMoreButton.style.display = "none";
    }
}


// Delete a movie by ID
function deleteMovie(id) {
    fetch(`/api/admin/movies/${id}`, {
        method: "DELETE",
        headers: {
            "Accept": "application/json",
        },
    })
        .then((response) => {
            if (response.ok) {
                alert("Movie deleted successfully!");
                loadMovies(); // Reload the movies table
            } else {
                return response.json().then((error) => {
                    console.error("Error deleting movie:", error);
                    alert("Failed to delete movie.");
                });
            }
        })
        .catch((error) => {
            console.error("Error deleting movie:", error);
            alert("Failed to delete movie.");
        });
}

// Edit a movie by ID
function editMovie(id) {
    fetchMovieDetails(id)
        .then((movie) => {
            toggleMovieCard(true); // Open popup for editing
            populateForm(movie); // Populate the form with movie data
            setFormToEditMode(id); // Set the form to editing mode
        })
        .catch((error) => {
            console.error("Error fetching movie details:", error);
            alert("Failed to load movie details.");
        });
}

// Populate the form with movie data
function populateForm(movie) {
    console.log("Movie data being populated:", movie); // Log movie data

    document.getElementById("title").value = movie.title;
    document.getElementById("description").value = movie.description || "";
    document.getElementById("poster_url").value =
        movie.poster_url.startsWith("/") || movie.poster_url.startsWith("http")
            ? movie.poster_url
            : `${window.location.origin}/posters/${movie.poster_url}`;
    document.getElementById("trailer_url").value = movie.trailer_url || "";
    document.getElementById("duration").value = movie.duration;

    showPosterPreview(movie.poster_url); // Log is already inside showPosterPreview
}


// Set the form to editing mode
function setFormToEditMode(id) {
    const form = document.getElementById("add-movie-form");
    form.dataset.editing = id; // Set editing mode
    document.querySelector(".btn-submit").textContent = "Save Changes"; // Update button text

    // Remove any existing event listeners to avoid duplicate triggers
    form.onsubmit = null;

    // Attach a single update handler
    form.onsubmit = function (e) {
        e.preventDefault(); // Prevent default form submission
        handleUpdateMovie(id); // Save changes
    };
}


// Handle updating a movie
function handleUpdateMovie(id) {
    const form = document.getElementById("add-movie-form");
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());

    // Validate movie duration
    const duration = parseInt(data.duration, 10);
    if (duration < 40 || duration > 300) {
        alert("Movie duration must be between 40 and 300 minutes.");
        return;
    }

    fetch(`/api/admin/movies/${id}`, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
        },
        body: JSON.stringify(data), // Send updated movie data
    })
        .then((response) => {
            if (response.ok) {
                alert("Movie updated successfully!");
                toggleMovieCard(); // Close the popup
                loadMovies(); // Refresh the movies table
            } else {
                return response.json().then((errorData) => {
                    console.error("Error updating movie:", errorData);
                    alert("Failed to update movie: " + (errorData.message || "Unknown error"));
                });
            }
        })
        .catch((error) => {
            console.error("Error updating movie:", error);
            alert("Failed to update movie.");
        });
}


function initializeTableEventListeners() {
    const viewMoreButton = document.getElementById("view-more");
    if (viewMoreButton) {
        viewMoreButton.addEventListener("click", () => {
            loadMovies(); // Load the next page of movies
        });
    }
}

// Export the table-related functions for reuse
export { loadMovies, deleteMovie, editMovie, initializeTableEventListeners };
