import { roomScheduleState } from './state.js';

export function fetchSchedule(roomId, day) {
    if (!roomId || !day) {
        console.error('Invalid parameters for fetchSchedule.');
        return;
    }

    const tbody = document.getElementById(`schedule-body-${roomId}`);
    if (!tbody) {
        console.error(`Element with ID 'schedule-body-${roomId}' not found.`);
        return;
    }

    // Show loading message
    tbody.innerHTML = '<tr><td colspan="3" class="loading-text">Loading...</td></tr>';

    // Fetch the schedule data
    fetch(`/rooms/${roomId}/schedule?day=${day}`)
        .then(response => response.json())
        .then(data => {
            const rows = data.movies.map(movie => `
                <tr>
                    <td>${movie.time || 'N/A'}</td>
                    <td>
                        <a href="/movies/${movie.id}?date=${day}" class="movie-link">
                            ${movie.title || 'N/A'}
                        </a>
                    </td>
                    <td>${movie.price ? `$${movie.price}` : 'N/A'}</td>
                </tr>
            `).join('');

            tbody.innerHTML = rows || '<tr><td colspan="3">No schedules for selected date.</td></tr>';
        })
        .catch(error => {
            console.error('Error fetching schedule:', error);
            tbody.innerHTML = '<tr><td colspan="3" class="loading-text">Error loading schedule.</td></tr>';
        });

    // Store the current filter day for the room
    roomScheduleState[roomId] = day;
}

export function setActiveButton(roomId, selectedDay) {
    const filterSection = document.querySelector(`#schedule-${roomId} .filter-section`);
    if (!filterSection) {
        console.error(`Filter section for room ${roomId} not found.`);
        return;
    }

    // Reset all filter buttons to inactive
    const buttons = filterSection.querySelectorAll('.filter-btn');
    buttons.forEach(button => button.classList.remove('active'));

    // Set the selected button to active if selectedDay is valid
    if (selectedDay) {
        const activeButton = filterSection.querySelector(`.filter-btn[data-day="${selectedDay}"]`);
        if (activeButton) activeButton.classList.add('active');
    }
}

