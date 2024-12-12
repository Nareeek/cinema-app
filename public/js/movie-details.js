document.addEventListener('DOMContentLoaded', () => {
    const scheduleBody = document.getElementById('schedule-body');
    const movieId = document.getElementById('movie-id').value; // Get movie ID from a hidden input

    function fetchSchedule(day) {
        scheduleBody.innerHTML = '<tr><td colspan="4" class="loading-text">Loading...</td></tr>';

        fetch(`/movies/${movieId}/schedule?day=${day}`)
            .then(response => response.json())
            .then(data => {
                // alert(JSON.stringify(data, null, 2)); // Shows the entire response in a readable format
                const rows = data.schedules.map(schedule => `
                    <tr>
                        <td>${schedule.time || 'N/A'}</td>
                        <td>${schedule.room || 'N/A'}</td>
                        <td>${schedule.price + "$" || 'N/A'}</td>
                        <td>
                            <button class="action-btn book-btn" onclick="window.location.href='/booking/${schedule.id}'">Book</button>
                        </td>
                    </tr>
                `).join('');
                scheduleBody.innerHTML = rows || '<tr><td colspan="4">No schedules available.</td></tr>';
            })
            .catch(error => {
                scheduleBody.innerHTML = `
                    <tr>
                        <td colspan="4" class="loading-text">
                            Error loading schedule. <button onclick="fetchSchedule('${day}')">Retry</button>
                        </td>
                    </tr>`;
                console.error(error);
            });
    }

    window.filterSchedule = function(day) {
        document.querySelectorAll('.filter-btn').forEach(button => {
            button.classList.remove('active');
            button.setAttribute('aria-pressed', 'false');
        });
        const activeButton = document.querySelector(`.filter-btn[data-day="${day}"]`);
        if (activeButton) {
            activeButton.classList.add('active');
            activeButton.setAttribute('aria-pressed', 'true');
        }
        fetchSchedule(day);
    };

    // Load today's schedule by default
    fetchSchedule('today');
});
