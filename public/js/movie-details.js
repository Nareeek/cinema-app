import { initializeFlatpickr } from './movies/flatpickr-init.js';
import { fetchData } from './movies/fetch-utils.js';
import { setActiveButton } from './movies/button-utils.js';
import { fetchSchedule, fetchRoomsForMovie } from './movies/fetch-movie-data.js';

document.addEventListener('DOMContentLoaded', () => {
    // DOM Elements
    const movieId = document.getElementById('movie-id')?.value;
    const movieDetails = document.querySelector('.movie-details');
    const scheduleBody = document.getElementById('schedule-body');
    const roomTable = document.querySelector('#room-table-body');
    const todayButton = document.querySelector('#today-button');
    const tomorrowButton = document.querySelector('#tomorrow-button');
    const datePicker = document.querySelector('#date-picker');

    // Date management
    const urlParams = new URLSearchParams(window.location.search);
    const preselectedDate = movieDetails?.dataset.selectedDate;
    const selectedDate = urlParams.get('date') || preselectedDate || 'today';
    let lastSelectedDate = null;

    // Initialize Page
    function initializePage() {
        if (selectedDate === 'today' || selectedDate === 'tomorrow') {
            setActiveButton(selectedDate); // Highlight today/tomorrow button
            datePicker.value = ''; // Reset the date picker to empty state
        } else {
            datePicker.value = selectedDate; // Show preselected custom date
            setActiveButton(null); // Clear any button highlights
        }

        fetchSchedule(movieId, scheduleBody, selectedDate);
        fetchRoomsForMovie(movieId, roomTable, selectedDate, lastSelectedDate, (updatedDate) => {
            lastSelectedDate = updatedDate;
        });
    }

    initializePage();

    // Flatpickr Initialization
    initializeFlatpickr(datePicker, (dateStr) => {
        setActiveButton(null); // Clear button states
        fetchSchedule(movieId, scheduleBody, dateStr);
        fetchRoomsForMovie(movieId, roomTable, dateStr, lastSelectedDate, (updatedDate) => {
            lastSelectedDate = updatedDate;
        });
    });

    // Event Listeners for Buttons
    todayButton?.addEventListener('click', () => {
        setActiveButton('today');
        fetchSchedule(movieId, scheduleBody, 'today');
        fetchRoomsForMovie(movieId, roomTable, 'today', lastSelectedDate, (updatedDate) => {
            lastSelectedDate = updatedDate;
        });
    });

    tomorrowButton?.addEventListener('click', () => {
        setActiveButton('tomorrow');
        fetchSchedule(movieId, scheduleBody, 'tomorrow');
        fetchRoomsForMovie(movieId, roomTable, 'tomorrow', lastSelectedDate, (updatedDate) => {
            lastSelectedDate = updatedDate;
        });
    });
});
