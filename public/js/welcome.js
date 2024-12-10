let currentSlide = 0;
let slideshowImages = [];

// Fetch slideshow images dynamically
function loadSlideshow() {
    fetch('/api/slideshow-images')
        .then(response => response.json())
        .then(images => {
            slideshowImages = images;
            updateSlideshow();
            createDots();
        });
}

// Update slideshow image
function updateSlideshow() {
    const slideshowImage = document.getElementById('slideshow-image');
    slideshowImage.src = slideshowImages[currentSlide];
    
    // Handle broken image fallback
    slideshowImage.onerror = () => {
        slideshowImage.src = '/images/placeholder.jpg'; // Fallback image
    };

    slideshowImage.onclick = () => {
        alert('Image clicked! You can link to a movie or any page here.'); // Update logic if necessary
    };

    // Highlight active dot
    document.querySelectorAll('#slideshow-dots span').forEach((dot, index) => {
        dot.classList.toggle('active', index === currentSlide);
    });
}

// Navigate to the previous slide
function prevSlide() {
    currentSlide = (currentSlide - 1 + slideshowImages.length) % slideshowImages.length;
    updateSlideshow();
}

// Navigate to the next slide
function nextSlide() {
    currentSlide = (currentSlide + 1) % slideshowImages.length;
    updateSlideshow();
}

// Create dots for the slideshow
function createDots() {
    const dotsContainer = document.getElementById('slideshow-dots');
    dotsContainer.innerHTML = ''; // Clear existing dots

    slideshowImages.forEach((_, index) => {
        const dot = document.createElement('span');
        dot.classList.add('dot');
        if (index === currentSlide) dot.classList.add('active');
        dot.onclick = () => {
            currentSlide = index;
            updateSlideshow();
        };
        dotsContainer.appendChild(dot);
    });
}

// Fetch and display rooms
function loadRooms() {
    fetch('/api/rooms')
        .then(response => response.json())
        .then(data => {
            const roomList = document.getElementById('room-list');
            roomList.innerHTML = ''; // Clear list
            data.forEach(room => {
                const roomCard = document.createElement('div');
                roomCard.classList.add('room-card');
                roomCard.innerHTML = `
                    <h3>${room.name}</h3>
                    <p>Type: ${room.type}</p>
                    <p>Capacity: ${room.capacity}</p>
                `;
                roomCard.onclick = () => loadSchedules(room.id);
                roomList.appendChild(roomCard);
            });
        });
}

// Fetch and display schedules for a room
function loadSchedules(roomId) {
    fetch(`/api/rooms/${roomId}/schedules`)
        .then(response => response.json())
        .then(data => {
            const scheduleTable = document.getElementById('schedule-table').querySelector('tbody');
            scheduleTable.innerHTML = ''; // Clear table

            if (data.length === 0) {
                scheduleTable.innerHTML = '<tr><td colspan="3">No schedules available for this room.</td></tr>';
            } else {
                data.forEach(schedule => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${new Date(schedule.schedule_time).toLocaleString()}</td>
                        <td>${schedule.movie.title}</td>
                        <td>$${schedule.price.toFixed(2)}</td>
                    `;
                    scheduleTable.appendChild(row);
                });
            }

            document.getElementById('schedules').style.display = 'block'; // Show schedules section
        })
        .catch(() => {
            alert('Failed to load schedules. Please try again.');
        });
}

// Initialize slideshow and rooms
loadSlideshow();
loadRooms();
document.getElementById('prev-slide').onclick = prevSlide;
document.getElementById('next-slide').onclick = nextSlide;
