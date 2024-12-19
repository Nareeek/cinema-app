import { toggleMovieCard } from "./formUtils.js";
import { editMovie, deleteMovie, loadMovies, initializeTableEventListeners } from "./table.js";
import { handleFormSubmission, posterPreview, initializeDynamicValidation } from "./form.js";

// Expose functions globally for use in HTML
window.toggleMovieCard = toggleMovieCard;
window.editMovie = editMovie;
window.deleteMovie = deleteMovie;

// Initialize functionality
document.addEventListener("DOMContentLoaded", function () {
    loadMovies();
    handleFormSubmission();
    posterPreview(); // Enable poster preview
    initializeDynamicValidation(); // Initialize validation dynamically
    initializeTableEventListeners(); // Attach dynamic listeners to table actions
});
