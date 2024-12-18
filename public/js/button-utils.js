export function setActiveButton(day) {
    // Remove all active states
    document.querySelectorAll('.filter-btn').forEach((button) => {
        button.classList.remove('active');
        button.setAttribute('aria-pressed', 'false');
    });

    // Reset the date picker placeholder if "Today" or "Tomorrow" is selected
    const datePicker = document.querySelector('.date-picker');
    if (day === 'today' || day === 'tomorrow') {
        if (datePicker?._flatpickr) {
            datePicker._flatpickr.clear(); // Clear Flatpickr value explicitly
        }
        datePicker.value = ''; // Clear date picker value
        datePicker.setAttribute('placeholder', 'Pick a date'); // Set placeholder back
    }

    // Highlight button ONLY if day is "today" or "tomorrow"
    if (day === 'today' || day === 'tomorrow') {
        const activeButton = document.querySelector(`.filter-btn[data-day="${day}"]`);
        activeButton?.classList.add('active');
        activeButton?.setAttribute('aria-pressed', 'true');
    }
}
