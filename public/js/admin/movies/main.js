import { toggleMovieCard } from "./formUtils.js";
import { editMovie, deleteMovie, loadMovies, initializeTableEventListeners, getCurrentPage, setCurrentPage } from "./table.js";
import { handleFormSubmission, posterPreview, initializeDynamicValidation } from "./form.js";


// Expose functions globally for use in HTML
window.toggleMovieCard = toggleMovieCard;
window.editMovie = editMovie;
window.deleteMovie = deleteMovie;

// Initialize functionality
document.addEventListener("DOMContentLoaded", function () {
    setCurrentPage(1); // Reset the page count on load
    loadMovies(getCurrentPage()); // Always load from the first page
    handleFormSubmission();
    posterPreview(); // Enable poster preview
    initializeDynamicValidation(); // Initialize validation dynamically
    initializeTableEventListeners(); // Attach dynamic listeners to table actions
});
