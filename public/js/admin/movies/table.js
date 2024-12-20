import { toggleMovieCard } from "./formUtils.js";
import { showPosterPreview } from "./utils.js";
import { fetchMovies, fetchMovieDetails } from "./api.js";

let currentPage = 1; // Track the current page globally
let isLoadingMovies = false; // Prevent duplicate loads

function loadMovies(page = 1) {
    if (isLoadingMovies) return; // Skip if already loading
    isLoadingMovies = true;

    console.log("Loading movies for page:", page);
    fetchMovies(page)
        .then((data) => {
            console.log("Movies data fetched:", data);
            renderMovies(data, page); // Render the movies into the table
            handlePagination(data); // Handle pagination ("View More" button)
        })
        .catch((error) => {
            console.error("Error loading movies:", error);
            alert("Failed to load movies.");
        })
        .finally(() => {
            isLoadingMovies = false; // Reset loading state
        });
}

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
            <td>${movie.description || "No description available"}</td> <!-- New Column -->
            <td>${movie.duration} min</td>
            <td>
                <button class="btn-edit" onclick="editMovie(${movie.id})">✏ Edit</button>
                <button class="btn-delete" onclick="deleteMovie(${movie.id})">❌ Delete</button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function handlePagination(data) {
    const viewMoreButton = document.getElementById("view-more");

    if (!viewMoreButton) {
        console.warn("View More button not found in the DOM.");
        return; // Exit the function if the button is not present
    }

    // Check if more pages are available
    if (data.next_page_url) {
        viewMoreButton.style.display = "block";
        viewMoreButton.onclick = () => {
            currentPage++;
            loadMovies(currentPage); // Load the next page of movies
        };
    } else {
        viewMoreButton.style.display = "none";
    }
}

// Deletes a movie by ID
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
                loadMovies(); // Reload movies after deletion
            } else {
                alert("Failed to delete movie.");
            }
        })
        .catch((error) => {
            console.error("Error deleting movie:", error);
            alert("Error deleting movie.");
        });
}

// Handles editing a movie
function editMovie(id) {
    fetchMovieDetails(id)
        .then((movie) => {
            console.log("Movie data being populated:", movie);
            toggleMovieCard(true); // Open the popup and set the title for editing
            populateForm(movie); // Populate the form with movie details
            setFormToEditMode(id); // Enable editing mode
        })
        .catch((error) => {
            console.error("Error fetching movie details:", error);
            alert("Failed to load movie details.");
        });
}

// Populates the form with movie data for editing
function populateForm(movie) {
    const form = document.getElementById("add-movie-form");

    document.getElementById("title").value = movie.title;
    document.getElementById("description").value = movie.description || "";
    document.getElementById("poster_url").value = movie.poster_url;
    document.getElementById("trailer_url").value = movie.trailer_url || "";
    document.getElementById("duration").value = movie.duration;

    // Show poster preview with corrected URL
    showPosterPreview(movie.poster_url);
}

function setFormToEditMode(id) {
    const form = document.getElementById("add-movie-form");
    form.dataset.editing = id; // Set editing mode
    document.querySelector(".btn-submit").textContent = "Save Changes"; // Update button text
}

function initializeTableEventListeners() {
    const viewMoreButton = document.getElementById("view-more");
    if (viewMoreButton) {
        viewMoreButton.addEventListener("click", () => {
            currentPage++;
            loadMovies(currentPage);
        });
    }
}

// Export the table-related functions for reuse
export { loadMovies, deleteMovie, editMovie, initializeTableEventListeners };
