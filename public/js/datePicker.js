import { roomScheduleState } from './state.js';
import { fetchSchedule, setActiveButton } from './schedule.js';

export default function setupDatePickers() {
    const datePickers = document.querySelectorAll('.date-picker');

    datePickers.forEach(picker => {
        const roomId = picker.dataset.roomId;

        flatpickr(picker, {
            dateFormat: 'Y-m-d',
            onChange: function (selectedDates, dateStr) {
                if (!dateStr) return; // Do nothing if no date is selected

                // Update state and fetch schedule for selected date
                roomScheduleState[roomId] = dateStr;
                fetchSchedule(roomId, dateStr);

                // Ensure "Today" and "Tomorrow" buttons are inactive
                const filterSection = document.querySelector(`.filter-section[data-room-id="${roomId}"]`);
                if (filterSection) {
                    const buttons = filterSection.querySelectorAll('.filter-btn');
                    buttons.forEach(button => button.classList.remove('active'));
                }
            },
            onOpen: function () {
                // Prevent the room section from closing
                const scheduleSection = document.getElementById(`schedule-${roomId}`);
                if (scheduleSection) {
                    scheduleSection.dataset.keepOpen = true;
                }
            },
            onClose: function () {
                // Reset the "keepOpen" flag when the date picker closes
                const scheduleSection = document.getElementById(`schedule-${roomId}`);
                if (scheduleSection) {
                    scheduleSection.dataset.keepOpen = false;
                }
            },
        });
    });
}
