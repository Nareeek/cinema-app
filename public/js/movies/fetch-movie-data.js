import { fetchData } from './fetch-utils.js';

export function fetchSchedule(movieId, scheduleBody, dayOrDate) {
    scheduleBody.innerHTML = '<tr><td colspan="4" class="loading-text">Loading...</td></tr>';

    const url = `/movies/${movieId}/schedule?day=${dayOrDate}`;
    fetchData(
        url,
        (data) => {
            if (!data.schedules || data.schedules.length === 0) {
                scheduleBody.innerHTML = '<tr><td colspan="4">No schedules available for the selected date.</td></tr>';
            } else {
                const rows = data.schedules.map((schedule) => `
                    <tr>
                        <td>${schedule.time || 'N/A'}</td>
                        <td>${schedule.room || 'N/A'}</td>
                        <td>${schedule.price ? `${schedule.price}$` : 'N/A'}</td>
                        <td>
                            <button class="action-btn book-btn" onclick="window.location.href='/bookings/${schedule.id}'">Book</button>
                        </td>
                    </tr>
                `).join('');
                scheduleBody.innerHTML = rows;
            }
        },
        (error) => {
            console.error('Error fetching schedule:', error);
            scheduleBody.innerHTML = `
                <tr>
                    <td colspan="4" class="loading-text">
                        Error loading schedule. <button onclick="fetchSchedule('${movieId}', '${dayOrDate}')">Retry</button>
                    </td>
                </tr>`;
        }
    );
}

export function fetchRoomsForMovie(movieId, roomTable, date, lastSelectedDate, updateLastSelectedDate) {
    if (lastSelectedDate === date) return;

    roomTable.innerHTML = '<tr><td colspan="3" class="loading-text">Loading...</td></tr>';
    const url = `/movies/${movieId}/rooms?date=${date}`;
    fetchData(
        url,
        (data) => {
            if (!data.rooms || data.rooms.length === 0) {
                roomTable.innerHTML = '<tr><td colspan="3">No rooms available for the selected date.</td></tr>';
            } else {
                const rows = data.rooms.map((room) => `
                    <tr>
                        <td>${room.name}</td>
                        <td>${room.capacity}</td>
                        <td>${room.schedule_time || 'No schedule available'}</td>
                    </tr>
                `).join('');
                roomTable.innerHTML = rows;
            }
        },
        (error) => {
            console.error('Error fetching rooms:', error);
            roomTable.innerHTML = "<tr><td colspan='3'>Error loading rooms. Please try again.</td></tr>";
        }
    );

    updateLastSelectedDate(date);
}
