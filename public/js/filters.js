import { fetchSchedule, setActiveButton } from './schedule.js';

export default function setupFilters() {
    document.querySelectorAll('.filter-btn').forEach(button => {
        button.addEventListener('click', (event) => {
            event.stopPropagation(); // Prevent parent section toggle
            const roomId = button.dataset.roomId;
            const day = button.dataset.day;

            if (roomId && day) {
                setActiveButton(roomId, day);
                fetchSchedule(roomId, day);
            }
        });
    });
}
