document.addEventListener('DOMContentLoaded', () => {
    // Select DOM elements once at the start
    const movieDetails = document.querySelector('.movie-details');
    const movieId = document.getElementById('movie-id')?.value;
    const scheduleBody = document.getElementById('schedule-body');
    const roomTable = document.querySelector("#room-table-body");
    const todayButton = document.querySelector("#today-button");
    const tomorrowButton = document.querySelector("#tomorrow-button");
    const datePicker = document.querySelector("#date-picker");

    // Get the selected date from URL or dataset (fallback to 'today')
    const urlParams = new URLSearchParams(window.location.search);
    const preselectedDate = movieDetails?.dataset.selectedDate;
    const selectedDate = urlParams.get('date') || preselectedDate || 'today';

    let lastSelectedDate = null; // Prevent redundant fetches for rooms

    // Initialize the schedule on page load
    function initializePage() {
        if (selectedDate === 'today' || selectedDate === 'tomorrow') {
            setActiveButton(selectedDate); // Highlight today/tomorrow button
            datePicker.value = ''; // Reset the date picker to empty state
        } else {
            datePicker.value = selectedDate; // Show preselected custom date
            setActiveButton(null); // Clear any button highlights
        }
    
        // Fetch schedules and rooms
        fetchSchedule(selectedDate);
        fetchRoomsForMovie(selectedDate);
    }

    // Call initialization
    initializePage();
    // Helper to fetch data and handle errors
    function fetchData(url, onSuccess, onError) {
        fetch(url)
            .then(response => response.json())
            .then(onSuccess)
            .catch(onError);
    }

    // Fetch movie schedule
    function fetchSchedule(dayOrDate) {
        scheduleBody.innerHTML = '<tr><td colspan="4" class="loading-text">Loading...</td></tr>';
        const url = `/movies/${movieId}/schedule?day=${dayOrDate}`;
        fetchData(
            url,
            (data) => {
                if (!data.schedules || data.schedules.length === 0) {
                    scheduleBody.innerHTML = '<tr><td colspan="4">No schedules available for the selected date.</td></tr>';
                } else {
                    const rows = data.schedules.map(schedule => `
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
                            Error loading schedule. <button onclick="fetchSchedule('${dayOrDate}')">Retry</button>
                        </td>
                    </tr>`;
            }
        );
    }

    // Fetch available rooms for a specific date
    function fetchRoomsForMovie(date) {
        if (lastSelectedDate === date) return; // Prevent redundant fetches
        lastSelectedDate = date;

        if (roomTable) {
            roomTable.innerHTML = '<tr><td colspan="3" class="loading-text">Loading...</td></tr>';
        }

        const url = `/movies/${movieId}/rooms?date=${date}`;
        fetchData(
            url,
            (data) => {
                if (!data.rooms || data.rooms.length === 0) {
                    roomTable.innerHTML = '<tr><td colspan="3">No rooms available for the selected date.</td></tr>';
                } else {
                    const rows = data.rooms.map(room => `
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
    }

    // Manage active button states
    function setActiveButton(day) {
        // Remove all active states
        document.querySelectorAll('.filter-btn').forEach(button => {
            button.classList.remove('active');
            button.setAttribute('aria-pressed', 'false');
        });
    
        // Highlight button ONLY if day is "today" or "tomorrow"
        if (day === 'today' || day === 'tomorrow') {
            const activeButton = document.querySelector(`.filter-btn[data-day="${day}"]`);
            activeButton?.classList.add('active');
            activeButton?.setAttribute('aria-pressed', 'true');
    
            if (datePicker) datePicker.value = ''; // Reset date picker to empty
        }
    }

    // Date picker initialization
    flatpickr('.date-picker', {
        altInput: true,
        altFormat: 'F j, Y',
        dateFormat: 'Y-m-d',
        minDate: 'today',
        onChange: (selectedDates, dateStr) => {
            setActiveButton(null); // Clear button states
            fetchSchedule(dateStr);
            fetchRoomsForMovie(dateStr);
        },
    });

    // Event listeners for today/tomorrow buttons
    todayButton?.addEventListener('click', () => {
        setActiveButton('today');       // Highlight Today button
        fetchSchedule('today');         // Fetch Today's schedule
        fetchRoomsForMovie('today');    // Fetch corresponding rooms
    });

    tomorrowButton?.addEventListener('click', () => {
        setActiveButton('tomorrow');    // Highlight Tomorrow button
        fetchSchedule('tomorrow');      // Fetch Tomorrow's schedule
        fetchRoomsForMovie('tomorrow'); // Fetch corresponding rooms
    });

    // Load today's schedule and rooms by default
    fetchSchedule(selectedDate);
    fetchRoomsForMovie(selectedDate);

    if (preselectedDate && preselectedDate !== 'today' && preselectedDate !== 'tomorrow') {
        datePicker.value = preselectedDate; // Set date picker value
        todayButton.disabled = true; // Disable Today button
        tomorrowButton.disabled = true; // Disable Tomorrow button
        fetchSchedule(preselectedDate);
    } else {
        // Default to 'today'
        setActiveButton('today');
        fetchSchedule('today');
    }
});
