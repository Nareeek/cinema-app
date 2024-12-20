// Validates whether a given string is a valid URL
function validateURL(url) {
    // Allow URLs that start with http(s) and end with valid image extensions
    const regex = /^(https?:\/\/).+\.(jpg|jpeg|png|gif|webp)$/i;
    return regex.test(url);
}

// Displays the poster preview based on the given URL
function showPosterPreview(url) {
    const posterPreview = document.getElementById("poster-preview");

    if (!url) {
        console.warn("Empty or invalid URL for preview:", url);
        posterPreview.style.display = "none";
        posterPreview.src = "";
        return;
    }

    // Construct full URL if the input is relative or incomplete
    let fullURL = url;
    if (!url.startsWith("http") && !url.startsWith("/storage/")) {
        fullURL = `${window.location.origin}/storage/posters/${url}`; // Assume it's in the storage posters directory
    } else if (url.startsWith("/storage/")) {
        fullURL = `${window.location.origin}${url}`;
    }

    console.log("Constructed preview URL:", fullURL);

    // Validate the constructed URL
    if (validateURL(fullURL)) {
        posterPreview.src = fullURL;
        posterPreview.style.display = "block";
    } else {
        console.warn("Invalid URL for preview:", fullURL);
        posterPreview.style.display = "none";
        posterPreview.src = "";
    }
}

// Export the utility functions
export { validateURL, showPosterPreview };
