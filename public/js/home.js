const slideshow = document.querySelector('.slideshow');
let isHovering = false;
let slideInterval;

// Function to switch slides
function switchSlide() {
    const slides = document.querySelectorAll('.slideshow .slide');
    const slideWidth = slides[0].offsetWidth + 10; // Include gap in width

    slideshow.scrollBy({ left: slideWidth, behavior: 'smooth' });

    if (slideshow.scrollLeft + slideshow.offsetWidth >= slideshow.scrollWidth) {
        slideshow.scrollTo({ left: 0, behavior: 'smooth' });
    }
}

document.querySelectorAll('.slideshow .slide img').forEach((img) => {
    img.addEventListener('click', () => {
        const movieId = img.dataset.movieId;
        if (movieId) {
            window.location.href = `/movies/${movieId}`;
        }
    });
});

// Start slideshow automatically
function startSlideshow() {
    slideInterval = setInterval(switchSlide, 3000);
}

// Pause slideshow when hovering
slideshow.addEventListener('mouseenter', () => {
    isHovering = true;
    clearInterval(slideInterval);
});

slideshow.addEventListener('mouseleave', () => {
    isHovering = false;
    startSlideshow();
});

// Ensure movie posters are clickable
document.querySelectorAll('.slideshow .slide img').forEach((img) => {
    img.addEventListener('click', () => {
        const movieId = img.dataset.movieId;
        window.location.href = `/movies/${movieId}`;
    });
});

startSlideshow();


// Room schedule functionality
function showRoomSchedule(roomElement) {
    const roomId = roomElement.getAttribute('data-room-id');
    fetch(`/rooms/${roomId}/schedule`)
        .then(response => response.json())
        .then(data => {
            const scheduleContainer = document.getElementById('room-schedule');
            scheduleContainer.innerHTML = `
                <h3>Schedule for Room ${data.name}</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Movie</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${data.movies.map(movie => `
                            <tr>
                                <td>${movie.title}</td>
                                <td>${movie.time}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            `;
        });
}
