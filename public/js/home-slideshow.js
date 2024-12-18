document.addEventListener('DOMContentLoaded', () => {
    const slideshowItems = document.querySelectorAll('.slide'); // Adjust selector based on your HTML structure

    slideshowItems.forEach((item) => {
        item.addEventListener('click', () => {
            const movieId = item.dataset.id; // Assume `data-id` contains the movie ID
            if (movieId) {
                // Redirect to movie-details page with the selected movie ID
                window.location.href = `/movies/${movieId}`;
            }
        });
    });
});
