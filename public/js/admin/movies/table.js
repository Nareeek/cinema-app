import { toggleMovieCard } from "./formUtils.js";
import { showPosterPreview } from "./utils.js";
import { fetchMovies, fetchMovieDetails } from "./api.js";


let isLoadingMovies = false; // Prevent duplicate loads
let currentPage = 1; // Track the current page globally

export function getCurrentPage() {
    return currentPage;
}

export function setCurrentPage(page) {
    currentPage = page; // Update the value
}


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
     currentPage = data.current_page;
    const lastPage = data.last_page;

    if (!currentPage || !lastPage) {
        alert("Current or last page not found in the data.");
        console.warn("Current or last page not found in the data.");
    }

    if (currentPage < lastPage) {
        viewMoreButton.style.display = "block";
        viewMoreButton.onclick = () => {
            currentPage++; // Increment the page
            loadMovies(currentPage); // Load the next page of movies
        };
    } else {
        viewMoreButton.style.display = "none"; // Hide the button if no more pages
    }
}

// Deletes a movie by ID
function deleteMovie(id) {
    const popup = document.getElementById("delete-confirm-popup");
    const confirmButton = document.getElementById("confirm-delete");
    const cancelButton = document.getElementById("cancel-delete");

     // Get the CSRF token from the meta tag in the HTML head
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    popup.classList.remove("hidden");

    confirmButton.onclick = () => {
        popup.classList.add("hidden");
        fetch(`/api/admin/movies/${id}`, {
            method: "DELETE",
            headers: {
                "Accept": "application/json",
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken, // Include the CSRF token in the headers
            },
        })
            .then((response) => {
                if (response.ok) {
                    alert("Movie deleted successfully!");
                    currentPage = 1; // Reset pagination
                    loadMovies(); // Reload movies
                } else {
                    alert("Failed to delete movie.");
                }
            })
            .catch((error) => {
                console.error("Error deleting movie:", error);
                alert("Error deleting movie.");
            });
    };

    cancelButton.onclick = () => {
        popup.classList.add("hidden");
    };
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
    const posterInput = document.getElementById("poster_url");
    const posterPreview = document.getElementById("poster-preview");
    const posterFileInput = document.getElementById("poster_file");

    form.reset();

    // Populate fields
    form.title.value = movie.title || "";
    form.description.value = movie.description || "";
    form.trailer_url.value = movie.trailer_url || "";
    form.duration.value = movie.duration || "";

    // Handle poster_url and preview
    if (movie.poster_url) {
        const fullURL = movie.poster_url.startsWith("/storage/")
            ? `${window.location.origin}${movie.poster_url}`
            : `${window.location.origin}/${movie.poster_url}`;

        posterInput.value = fullURL;
        posterPreview.src = fullURL;
        posterPreview.style.display = "block";
    } else {
        posterInput.value = "";
        posterPreview.style.display = "none";
    }

    // Reset file input
    posterFileInput.value = "";
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
