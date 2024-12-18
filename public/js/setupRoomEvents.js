import { fetchSchedule, setActiveButton } from './schedule.js';
import { roomScheduleState } from './state.js';

export default function setupRoomEvents() {
    const roomContainer = document.querySelector('.room-container');

    if (!roomContainer) return;

    // Event delegation for toggling schedules and handling clicks
    roomContainer.addEventListener('click', (event) => {
        // Ignore clicks on filter buttons and date picker
        if (
            event.target.classList.contains('filter-btn') || 
            event.target.classList.contains('date-picker')
        ) {
            return;
        }

        const roomCard = event.target.closest('.room-card');
        if (!roomCard) return;

        const roomId = roomCard.dataset.roomId;
        const scheduleSection = document.getElementById(`schedule-${roomId}`);
        if (!scheduleSection) return;

        // Toggle the schedule section
        scheduleSection.style.display = scheduleSection.style.display === 'none' ? 'block' : 'none';

        if (scheduleSection.style.display === 'block') {
            const lastDay = roomScheduleState[roomId] || 'today';
            fetchSchedule(roomId, lastDay);
            setActiveButton(roomId, lastDay);
        }
    });

    // Event delegation for filter buttons (Today, Tomorrow)
    roomContainer.addEventListener('click', (event) => {
        if (event.target.classList.contains('filter-btn')) {
            const roomId = event.target.dataset.roomId;
            const selectedDay = event.target.dataset.day;

            // Update state and fetch schedule
            roomScheduleState[roomId] = selectedDay;
            fetchSchedule(roomId, selectedDay);

            // Reset the date picker to "Pick a date" placeholder
            const datePicker = document.querySelector(`.date-picker[data-room-id="${roomId}"]`);
            if (datePicker) datePicker.value = '';

            // Set the clicked button as active
            setActiveButton(roomId, selectedDay);
        }
    });
}
