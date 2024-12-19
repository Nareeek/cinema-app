// Validates whether a given string is a valid URL
function validateURL(url) {
    // Allow URLs that start with http(s) and end with valid image extensions
    const regex = /^(https?:\/\/).+\.(jpg|jpeg|png|gif|webp)$/i;
    return regex.test(url);
}


// Displays the poster preview based on the given URL
function showPosterPreview(url) {
    const posterPreview = document.getElementById("poster-preview");
    let basePath = `${window.location.origin}/posters/`;

    if (!url.startsWith("http") && !url.startsWith("/")) {
        url = basePath + url; // Construct full URL for local paths
    }

    console.log("Constructed preview URL:", url);

    if (validateURL(url)) {
        posterPreview.src = url;
        posterPreview.style.display = "block";
    } else {
        posterPreview.style.display = "none";
        console.error("Invalid URL for preview:", url);
    }
}


// Export the utility functions
export { validateURL, showPosterPreview };
