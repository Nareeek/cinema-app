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
function toggleMovieCard(isEdit = false, movieTitle = '') {
    const card = document.getElementById("add-movie-card");
    const form = document.getElementById("add-movie-form");

    // Toggle the visibility of the card
    card.classList.toggle("hidden");

    if (card.classList.contains("hidden")) {
        // If hiding the form, reset it
        resetForm();
    } else {
        // If showing the form, set the title dynamically
        if (isEdit) {
            form.dataset.editing = true; // Set editing state
            setPopupTitle("Edit the Movie"); // Edit mode title
            document.querySelector(".btn-submit").textContent = "Save Changes"; // Update button text
        } else {
            form.dataset.editing = ""; // Clear editing state
            setPopupTitle("Add New Movie"); // Add mode title
            document.querySelector(".btn-submit").textContent = "Add Movie"; // Reset button text
        }
    }
}

// Resets the form
function resetForm() {
    const form = document.getElementById("add-movie-form");
    form.reset(); // Reset all form fields
    form.dataset.editing = ""; // Clear editing state
    document.querySelector(".btn-submit").textContent = "Add Movie"; // Reset button text
    document.getElementById("poster-preview").style.display = "none"; // Hide poster preview
}

// Export the functions for reuse
export { toggleMovieCard, resetForm, setPopupTitle };
