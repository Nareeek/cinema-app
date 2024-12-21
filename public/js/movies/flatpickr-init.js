export function initializeFlatpickr(datePicker, onChangeCallback) {
    flatpickr(datePicker, {
        altInput: true,
        altFormat: 'F j, Y',
        dateFormat: 'Y-m-d',
        minDate: 'today',
        onChange: (selectedDates, dateStr) => {
            onChangeCallback(dateStr);
        },
    });
}
