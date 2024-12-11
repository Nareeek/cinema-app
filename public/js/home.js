// home.js

document.addEventListener('DOMContentLoaded', () => {
    // Slideshow functionality
    const slideshow = document.querySelector('.slideshow');
    let slideIndex = 0;
    let isHovering = false;

    // Function to switch slides
    function switchSlide() {
        if (!isHovering) {
            const slides = document.querySelectorAll('.slideshow .slide');
            slides.forEach((slide, index) => {
                slide.style.transform = `translateX(${(index - slideIndex) * 100}%)`;
            });
            slideIndex = (slideIndex + 1) % slides.length;
        }
    }

    // Start the slideshow
    function startSlideshow() {
        setInterval(switchSlide, 3000);
    }

    // Stop slideshow on hover
    slideshow.addEventListener('mouseenter', () => isHovering = true);
    slideshow.addEventListener('mouseleave', () => isHovering = false);

    // Make movie posters clickable
    document.querySelectorAll('.slideshow .slide img').forEach(img => {
        img.addEventListener('click', () => {
            const movieId = img.dataset.movieId;
            window.location.href = `/movies/${movieId}`;
        });
    });

    startSlideshow();

    // Show room schedule
    function showRoomSchedule(roomId) {
        fetch(`/rooms/${roomId}/schedule`)
            .then(response => response.json())
            .then(data => {
                const scheduleContainer = document.getElementById('room-schedule');
                scheduleContainer.innerHTML = `
                    <h3>Schedule for Room: ${data.name}</h3>
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
            })
            .catch(error => console.error('Error fetching schedule:', error));
    }

    // Language switching functionality
    function changeLanguage(lang) {
        alert(`Language changed to: ${lang}`);
        // Add further logic to update the interface language
    }
});