import { loadMovies } from "./table.js"; // Import loadMovies from table.js
import { toggleMovieCard } from "./formUtils.js"; // Import toggleMovieCard for toggling the form card
import { validateURL, showPosterPreview } from "./utils.js"; // Utility functions

// Enables poster preview functionality
function posterPreview() {
    const posterInput = document.getElementById("poster_url");
    const posterPreview = document.getElementById("poster-preview");

    posterInput.addEventListener("input", () => {
        const url = posterInput.value;

        // Check if the URL is valid
        const isValid = validateURL(url);

        console.log("Poster URL Validation:", { url, isValid }); // Debugging log

        if (isValid) {
            // Show the preview
            let fullURL = url;

            // Add the base path for local images if needed
            if (!url.startsWith("http") && !url.startsWith("/")) {
                fullURL = `${window.location.origin}/posters/${url}`;
            }

            console.log("Constructed Preview URL:", fullURL);

            posterPreview.src = fullURL;
            posterPreview.style.display = "block";
        } else {
            // Hide the preview
            posterPreview.style.display = "none";
        }
    });
}


// Handles form submission for adding or editing a movie
function handleFormSubmission() {
    const form = document.getElementById("add-movie-form");
    const submitButton = form.querySelector(".btn-submit");
    const loadingOverlay = document.getElementById("loading-overlay");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());

        // Validate inputs
        const isPosterValid = validateURL(data.poster_url);
        const isDurationValid = data.duration >= 40 && data.duration <= 300;

        const isFormValid = isPosterValid && isDurationValid;

        console.log("Form valid status:", isFormValid); // Debugging log

        if (!isFormValid) {
            alert("Please ensure all fields are valid before submitting.");
            return;
        }

        // Proceed with submission
        const editingId = form.dataset.editing;
        const url = editingId ? `/api/admin/movies/${editingId}` : "/api/admin/movies";
        const method = editingId ? "PUT" : "POST";

        loadingOverlay.classList.add("show");
        submitButton.disabled = true;

        fetch(url, {
            method: method,
            headers: { "Content-Type": "application/json", "Accept": "application/json" },
            body: JSON.stringify(data),
        })
        .then((response) => {
            if (!response.ok) {
                return response.json().then((err) => Promise.reject(err));
            }
            alert(editingId ? "Movie updated successfully!" : "Movie added successfully!");
            toggleMovieCard(false); // Close popup
            loadMovies(); // Refresh table
        })
        .catch((error) => {
            console.error("Error saving movie:", error);
            alert("Failed to save movie.");
        })
        .finally(() => {
            loadingOverlay.classList.remove("show");
            submitButton.disabled = false;
        });
    });
}



function initializeDynamicValidation() {
    const posterInput = document.getElementById("poster_url");
    posterInput.addEventListener("input", () => {
        const posterPreview = document.getElementById("poster-preview");
        const url = posterInput.value;

        if (validateURL(url)) {
            posterPreview.src = url;
            posterPreview.style.display = "block";
        } else {
            posterPreview.style.display = "none";
        }
    });
}


function toggleSubmitButton() {
    const form = document.getElementById("add-movie-form");
    const submitButton = form.querySelector(".btn-submit");

    const isFormValid = form.checkValidity(); // Check HTML5 validation rules
    console.log("Form valid status:", isFormValid); // Debugging
    submitButton.disabled = !isFormValid; // Disable if invalid
}


// Export the functions
export { handleFormSubmission, posterPreview, initializeDynamicValidation };
