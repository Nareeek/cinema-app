// Function to set the popup title
function setPopupTitle(title) {
    console.log("Setting popup title to:", title); // Debugging log
    const popupTitle = document.getElementById("popup-title");
    if (popupTitle) {
        popupTitle.textContent = title; // Dynamically update the popup title
    } else {
        console.warn("Popup title element not found in the DOM.");
    }
}

// Toggles the visibility of the popup
function toggleMovieCard(isEditing = false) {
    const card = document.getElementById("add-movie-card");
    card.classList.toggle("hidden");

    if (card.classList.contains("hidden")) {
        resetForm(); // Reset only when hiding
    } else if (!isEditing) {
        setPopupTitle("Add New Movie");
    }
}

// Resets the form
function resetForm() {
    const form = document.getElementById("add-movie-form");
    form.reset();
    form.dataset.editing = ""; // Clear editing state
    document.querySelector(".btn-submit").textContent = "Add Movie"; // Reset button text
    document.getElementById("poster-preview").style.display = "none"; // Hide poster preview
}

// Export the functions for reuse
export { toggleMovieCard, resetForm, setPopupTitle };
