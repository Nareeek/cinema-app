document.addEventListener('DOMContentLoaded', () => {
    const scheduleBody = document.getElementById('schedule-body');
    const movieId = document.getElementById('movie-id')?.value; // Ensure movieId exists

    function fetchSchedule(dayOrDate) {
        showLoadingIndicator(); // Display loading
        scheduleBody.innerHTML = '<tr><td colspan="4" class="loading-text">Loading...</td></tr>';
    
        return fetch(`/movies/${movieId}/schedule?day=${dayOrDate}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (!data.schedules || data.schedules.length === 0) {
                    scheduleBody.innerHTML = '<tr><td colspan="4">No schedules available for the selected date.</td></tr>';
                    return;
                }
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
            })
            .catch(error => {
                console.error('Error fetching schedule:', error);
                scheduleBody.innerHTML = `
                    <tr>
                        <td colspan="4" class="loading-text">
                            Error loading schedule. <button onclick="fetchSchedule('${dayOrDate}')">Retry</button>
                        </td>
                    </tr>`;
            });
    }
          
    function showLoadingIndicator()
    {
        // Your loading logic here
        console.log("Loading");
    }

    window.filterSchedule = function (day) {
        document.querySelectorAll('.filter-btn').forEach((button) => {
            button.classList.remove('active');
            button.setAttribute('aria-pressed', 'false');
        });
        const activeButton = document.querySelector(`.filter-btn[data-day="${day}"]`);
        if (activeButton) {
            activeButton.classList.add('active');
            activeButton.setAttribute('aria-pressed', 'true');
        }
        fetchSchedule(day);
    };

    window.filterMovieScheduleByDate = function(event) {
        const selectedDate = event.target.value; // Get the selected date
        const scheduleBody = document.getElementById('schedule-body');
        scheduleBody.innerHTML = '<tr><td colspan="4" class="loading-text">Loading...</td></tr>';
    
        fetch(`/movies/${movieId}/schedule?date=${selectedDate}`)
            .then(response => response.json())
            .then(data => {
                const rows = data.schedules.map(schedule => `
                    <tr>
                        <td>${schedule.time || 'N/A'}</td>
                        <td>${schedule.room || 'N/A'}</td>
                        <td>${schedule.price ? `${schedule.price}$` : 'N/A'}</td>
                        <td><button class="action-btn book-btn" onclick="window.location.href='/bookings/${schedule.id}'">Book</button></td>
                    </tr>
                `).join('');
                scheduleBody.innerHTML = rows || '<tr><td colspan="4">No schedules available.</td></tr>';
            })
            .catch(error => {
                scheduleBody.innerHTML = `
                    <tr>
                        <td colspan="4" class="loading-text">
                            Error loading schedule. <button onclick="filterMovieScheduleByDate(event)">Retry</button>
                        </td>
                    </tr>`;
                console.error(error);
            });
    };

   window.filterSchedule = function (day) {
        document.querySelectorAll('.filter-btn').forEach((button) => {
            button.classList.remove('active');
            button.setAttribute('aria-pressed', 'false');
        });
        const activeButton = document.querySelector(`.filter-btn[data-day="${day}"]`);
        if (activeButton) {
            activeButton.classList.add('active');
            activeButton.setAttribute('aria-pressed', 'true');
        }
        fetchSchedule(day);
    };

    // Flatpickr date picker initialization
    flatpickr('.date-picker', {
        altInput: true,
        altFormat: 'F j, Y',
        dateFormat: 'Y-m-d',
        minDate: 'today',
        onChange: function (selectedDates, dateStr) {
            fetchSchedule(dateStr).then(() => {
                fetchRoomsForMovie(dateStr); // Call only after schedule is loaded
            });
        },
    });

    // Fetch rooms logic
    let lastSelectedDate = null;

    function fetchRoomsForMovie(date) {
        if (lastSelectedDate === date) return; // Prevent redundant fetches
        lastSelectedDate = date;

        console.log(`Fetching rooms for date: ${date}`);
        showLoadingIndicator();

        fetch(`/movies/${movieId}/rooms?date=${date}`)
            .then((response) => response.json())
            .then((data) => {
                console.log("Rooms fetched:", data.rooms);
                updateRoomTable(data.rooms);
            })
            .catch((error) => {
                console.error("Error fetching rooms:", error);
                showErrorInRoomTable();
            });
    }

    function showErrorInRoomTable() {
        const roomTable = document.querySelector("#room-table-body");
        if (roomTable) {
            roomTable.innerHTML = "<tr><td colspan='3'>Error loading rooms. Please try again.</td></tr>";
        }
    }

    // Update room table logic
    function updateRoomTable(rooms) {
        const roomTable = document.querySelector("#room-table-body");
        if (!roomTable) {
            console.error("Error: #room-table-body element is not found in the DOM.");
            return;
        }
        roomTable.innerHTML = ""; // Clear the table
    
        if (rooms.length === 0) {
            roomTable.innerHTML = "<tr><td colspan='3'>No rooms available for the selected date.</td></tr>";
            return;
        }
    
        rooms.forEach((room) => {
            const scheduleTime = room.schedule_time || "No schedule available";
            const row = `
                <tr>
                    <td>${room.name}</td>
                    <td>${room.capacity}</td>
                    <td>${scheduleTime}</td>
                </tr>
            `;
            roomTable.innerHTML += row;
        });
    }
    
    
    // Attach event listeners
    const todayButton = document.querySelector("#today-button");
    const tomorrowButton = document.querySelector("#tomorrow-button");
    const datePicker = document.querySelector("#date-picker");

    
    if (todayButton) {
        todayButton.addEventListener("click", () => {
            fetchRoomsForMovie("today");
        });
    } else {
        console.error("Error: #today-button element is not found in the DOM.");
    }

    if (tomorrowButton) {
        tomorrowButton.addEventListener("click", () => {
            fetchRoomsForMovie("tomorrow");
        });
    } else {
        console.error("Error: #tomorrow-button element is not found in the DOM.");
    }

    if (datePicker) {
        datePicker.addEventListener("change", (e) => {
            const selectedDate = e.target.value; // Ensure this is the correct date format
            fetchRoomsForMovie(selectedDate);
        });
    } else {
        console.error("Error: #date-picker element is not found in the DOM.");
    }

    // Load today's schedule and rooms by default
    fetchSchedule('today');
    fetchRoomsForMovie('today');
});