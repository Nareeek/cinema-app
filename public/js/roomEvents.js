import { fetchSchedule, setActiveButton } from './schedule.js';
import { roomScheduleState } from './state.js';

export default function setupRoomEvents() {
    document.querySelectorAll('.room-card').forEach((roomCard) => {
        roomCard.addEventListener('click', (event) => {
            // Stop propagation to avoid unexpected behavior
            event.stopPropagation();

            const roomId = roomCard.dataset.roomId;
            const section = document.getElementById(`schedule-${roomId}`);

            if (!section) return;

            // Toggle visibility
            const isVisible = section.style.display === 'block';
            section.style.display = isVisible ? 'none' : 'block';

            if (!isVisible) { // If section is opening
                const lastDay = roomScheduleState[roomId] || 'today';
                fetchSchedule(roomId, lastDay);
                setActiveButton(roomId, lastDay);
            }
        });
    });
}
