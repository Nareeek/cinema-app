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

document.querySelectorAll('.view-more-btn').forEach((button) => {
    const roomId = button.dataset.roomId; // Assume buttons have a `data-room-id` attribute
    button.addEventListener('click', () => {
        const hiddenRows = document.querySelectorAll(`#schedule-body-${roomId} .hidden-row`);
        hiddenRows.forEach((row, index) => {
            if (index < 10) row.classList.remove('hidden-row');
        });
        button.style.display = 'none';
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
    window.toggleScheduled = function (roomId, event) {
        if (event && (event.target.classList.contains('date-picker') || event.target.closest('.filter-section'))) {
            return; // Do nothing if the click is inside date picker or filter section
        }

        const section = document.getElementById(`schedule-${roomId}`);
        section.style.display = section.style.display === 'none' ? 'block' : 'none';
    
        if (section.style.display === 'block') {
            fetchSchedule(roomId, 'today'); // Fetch the schedule for the room when expanded
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
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then((data) => {
                if (!data.movies || data.movies.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="3">No movies available for the selected date.</td></tr>';
                    return;
                }
    
                const rows = data.movies
                    .map(
                        (movie) => `
                    <tr>
                        <td>${movie.time || 'N/A'}</td>
                        <td><a href="/movies/${movie.id}" class="movie-link">${movie.title || 'N/A'}</a></td>
                        <td>${movie.price ? `$${movie.price}` : 'N/A'}</td>
                    </tr>
                `
                    )
                    .join('');
                tbody.innerHTML = rows;
            })
            .catch((error) => {
                console.error('Error fetching schedule:', error);
                tbody.innerHTML = '<tr><td colspan="3" class="loading-text">Error loading schedule.</td></tr>';
            });
    }

    document.querySelectorAll('.view-more-btn').forEach((button) => {
        const roomId = button.dataset.roomId; // Assume buttons have a `data-room-id` attribute
        button.addEventListener('click', () => {
            const hiddenRows = document.querySelectorAll(`#schedule-body-${roomId} .hidden-row`);
            hiddenRows.forEach((row, index) => {
                if (index < 10) row.classList.remove('hidden-row');
            });
            button.style.display = 'none';
        });
    });

    // Function to filter schedules by a specific date
    window.filterScheduleByDate = function (event, roomId) {
        const selectedDate = event.target.value; // Get the selected date
        const tbody = document.getElementById(`schedule-body-${roomId}`);
        tbody.innerHTML = '<tr><td colspan="3" class="loading-text">Loading...</td></tr>';
    
        fetch(`/rooms/${roomId}/schedule?date=${selectedDate}`)
            .then((response) => response.json())
            .then((data) => {
                const rows = data.movies
                    .map(
                        (movie) => `
                    <tr>
                        <td>${movie.time || 'N/A'}</td>
                        <td><a href="/bookings/${movie.id}" class="movie-link">${movie.title || 'N/A'}</a></td>
                        <td>${movie.price ? `$${movie.price}` : 'N/A'}</td>
                    </tr>
                `
                    )
                    .join('');
                tbody.innerHTML = rows || '<tr><td colspan="3">No movies available.</td></tr>';
            })
            .catch((error) => {
                tbody.innerHTML = '<tr><td colspan="3" class="loading-text">Error loading schedule.</td></tr>';
                console.error('Error fetching schedule:', error);
            });
    };
    
    document.querySelectorAll('.date-picker').forEach((input) => {
        flatpickr(input, {
            altInput: true,
            altFormat: 'F j, Y',
            dateFormat: 'Y-m-d',
            minDate: 'today',
            onChange: function (selectedDates, dateStr) {
                const roomId = input.getAttribute('data-room-id');
                if (roomId) {
                    fetchSchedule(roomId, dateStr); // Room-specific logic
                }
            },
        });
    });
    

    startSlideshow();

});
