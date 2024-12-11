document.addEventListener('DOMContentLoaded', () => {
    const scheduleBody = document.getElementById('schedule-body');

    function fetchSchedule(day) {
        scheduleBody.innerHTML = '<tr><td colspan="4" class="loading-text">Loading...</td></tr>';

        fetch(`/movies/{{ $movie->id }}/schedule?day=${day}`)
            .then(response => response.json())
            .then(data => {
                const rows = data.schedules.map(schedule => `
                    <tr>
                        <td>${schedule.time || 'N/A'}</td>
                        <td>${schedule.room || 'N/A'}</td>
                        <td>${schedule.price || 'Free'}</td>
                        <td>
                            <button class="action-btn book-btn" onclick="window.location.href='/booking/${schedule.id}'">Book</button>
                        </td>
                    </tr>
                `).join('');
                scheduleBody.innerHTML = rows || '<tr><td colspan="4">No schedules available.</td></tr>';
            })
            .catch(error => {
                scheduleBody.innerHTML = '<tr><td colspan="4" class="loading-text">Error loading schedule.</td></tr>';
                console.error(error);
            });
    }

    window.filterSchedule = function(day) {
        document.querySelectorAll('.filter-btn').forEach(button => button.classList.remove('active'));
        document.querySelector(`.filter-btn[onclick="filterSchedule('${day}')"]`).classList.add('active');
        fetchSchedule(day);
    };

    // Load today's schedule by default
    fetchSchedule('today');
});