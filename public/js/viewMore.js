export default function setupViewMore() {
    document.querySelectorAll('.view-more-btn').forEach(button => {
        button.addEventListener('click', (event) => {
            event.stopPropagation(); // Prevent parent section toggle
            const roomId = button.dataset.roomId;
            const hiddenRows = document.querySelectorAll(`#schedule-body-${roomId} .hidden-row`);

            hiddenRows.forEach((row, index) => {
                if (index < 10) row.classList.remove('hidden-row');
            });

            if (document.querySelectorAll(`#schedule-body-${roomId} .hidden-row`).length === 0) {
                button.style.display = 'none';
            }
        });
    });
}
