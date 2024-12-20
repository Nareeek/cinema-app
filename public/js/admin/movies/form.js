import { loadMovies } from "./table.js"; // Import loadMovies from table.js
import { toggleMovieCard } from "./formUtils.js"; // Import toggleMovieCard for toggling the form card
import { validateURL, showPosterPreview } from "./utils.js"; // Utility functions

// Enables poster preview functionality
function posterPreview() {
    const posterInput = document.getElementById("poster_url");
    const posterFileInput = document.getElementById("poster_file");
    const posterPreview = document.getElementById("poster-preview");

    if (!posterInput || !posterPreview) {
        console.error("Poster input or preview element not found!");
        return;
    }

    // Handle URL input
    posterInput.addEventListener("input", () => {
        const url = posterInput.value;

        if (validateURL(url)) {
            showPosterPreview(url);
        } else {
            posterPreview.style.display = "none";
            posterPreview.src = "";
        }
    });

    // Handle file input
    posterFileInput.addEventListener("change", (event) => {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                posterPreview.src = e.target.result;
                posterPreview.style.display = "block";
                posterInput.value = ""; // Clear poster_url since we're using an uploaded file
            };
            reader.readAsDataURL(file);
        }
    });
}

// Handles form submission for adding or editing a movie
let isSubmitting = false; // Submission flag
let shouldClosePopup = true; // Ensure popup doesn't reopen unintentionally

function handleFormSubmission() {
    const form = document.getElementById("add-movie-form");
    const submitButton = form.querySelector(".btn-submit");
    const loadingOverlay = document.getElementById("loading-overlay");
    const posterFileInput = document.getElementById("poster_file");
    const posterInput = document.getElementById("poster_url");

    let isSubmitting = false; // Prevent duplicate submissions

    // Ensure the form submission is bound only once
    if (form.dataset.initialized) return;
    form.dataset.initialized = true;

    // Function to toggle submit button and remove 'required'
    function togglePosterURLRequired() {
        const fileUploaded = posterFileInput.files.length > 0;

        if (fileUploaded) {
            posterInput.removeAttribute("required");
            posterInput.value = ""; // Clear poster_url field when file is uploaded
        } else {
            posterInput.setAttribute("required", "required");
        }

        // Dynamically enable/disable the submit button
        const isPosterURLValid = validateURL(posterInput.value);
        submitButton.disabled = !(fileUploaded || isPosterURLValid);
    }

    // Run togglePosterURLRequired initially
    togglePosterURLRequired();

    // Listen for changes in poster_file and poster_url inputs
    posterFileInput.addEventListener("change", togglePosterURLRequired);
    posterInput.addEventListener("input", togglePosterURLRequired);

    form.addEventListener("submit", async function (event) {
        event.preventDefault();
        if (isSubmitting) return;
        isSubmitting = true;

        const formData = new FormData(form);
        const posterFile = posterFileInput.files[0];

        // Validate file size (e.g., max 5MB)
        if (posterFile && posterFile.size > 5 * 1024 * 1024) {
            alert("The uploaded file exceeds the maximum allowed size of 5MB.");
            return;
        }

        // Clear poster_url value if poster_file is uploaded
        if (posterFile) {
            formData.append("poster_file", posterFile);
            formData.set("poster_url", ""); // Clear poster_url field
        }

        // Log form data for debugging
        console.log("FormData being submitted:");
        for (const [key, value] of formData.entries()) {
            console.log(`${key}:`, value);
        }

        // Set API URL and method
        const editingId = form.dataset.editing;
        const url = editingId ? `/api/admin/movies/${editingId}` : "/api/admin/movies";
        const method = editingId ? "POST" : "POST";

        if (editingId) {
            formData.append("_method", "PUT"); // Laravel requires _method for PUT
        }

        // Show loading state
        loadingOverlay.classList.add("show");
        submitButton.disabled = true;

        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    Accept: "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                },
                body: formData,
            });

            if (!response.ok) {
                const errorData = await response.json();
                console.error("Server validation errors:", errorData);
                throw new Error(errorData.message || "Server validation failed.");
            }

            const data = await response.json();
            console.log("Response Data:", data);
            alert(editingId ? "Movie updated successfully!" : "Movie added successfully!");
            loadMovies(); // Refresh movie list
            toggleMovieCard(false); // Close popup
        } catch (error) {
            console.error("Error saving movie:", error);
            alert(error.message || "An unexpected server error occurred.");
            if (error.message.includes("kilobytes")) {
                alert("The uploaded file exceeds the size limit allowed by the server.");
            } else {
                alert(error.message || "Unexpected response from the server.");
            }
        } finally {
            // Reset loading state
            loadingOverlay.classList.remove("show");
            submitButton.disabled = false;
            isSubmitting = false;
        }
    });
}

// Dynamically validates poster URL and updates preview
function initializeDynamicValidation() {
    const posterInput = document.getElementById("poster_url");
    const posterPreview = document.getElementById("poster-preview");

    posterInput.addEventListener("input", () => {
        const url = posterInput.value;

        if (validateURL(url)) {
            posterPreview.src = url;
            posterPreview.style.display = "block";
        } else {
            posterPreview.style.display = "none";
        }
    });
}

// Export the functions
export { handleFormSubmission, posterPreview, initializeDynamicValidation };
