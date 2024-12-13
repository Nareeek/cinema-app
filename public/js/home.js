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

document.addEventListener('DOMContentLoaded', () => {
    window.toggleSchedule = function(roomId) {
        const section = document.getElementById(`schedule-${roomId}`);
        section.style.display = section.style.display === 'none' ? 'block' : 'none';

        if (section.style.display === 'block') {
            fetchSchedule(roomId, 'today');
        }
    };

    window.filterSchedule = function(event, roomId, day) {
        event.stopPropagation(); // Prevent the event from bubbling up
    
        const buttons = event.target.parentElement.querySelectorAll('.filter-btn');
        buttons.forEach(button => button.classList.remove('active'));
        event.target.classList.add('active');
    
        fetchSchedule(roomId, day);
    };

    function fetchSchedule(roomId, day) {
        const tbody = document.getElementById(`schedule-body-${roomId}`);
        tbody.innerHTML = '<tr><td colspan="3" class="loading-text">Loading...</td></tr>';
    
        fetch(`/rooms/${roomId}/schedule?day=${day}`)
            .then(response => response.json())
            .then(data => {
                const rows = data.movies.map(movie => `
                    <tr>
                        <td>${movie.time || 'N/A'}</td>
                        <td><a href="/bookings/${movie.id}" class="movie-link">${movie.title}</a></td>
                        <td>${movie.price ? `$${movie.price}` : 'N/A'}</td>
                    </tr>
                `).join('');
                tbody.innerHTML = rows || '<tr><td colspan="3">No movies available.</td></tr>';
            })
            .catch(error => {
                tbody.innerHTML = '<tr><td colspan="3" class="loading-text">Error loading schedule.</td></tr>';
                console.error("Error fetching schedule:", error);
            });
    }
});
