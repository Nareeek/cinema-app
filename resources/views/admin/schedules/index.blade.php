@extends('layouts.app')

@section('title', 'Schedule Management')

@section('content')
    <h1>Schedule Management</h1>
    <button onclick="showScheduleForm()">Add New Schedule</button>
    <div id="schedule-form" style="display: none;">
        <form id="schedule-form-data">
            <input type="hidden" id="schedule-id">
            <label for="room">Room:</label>
            <select id="room" name="room_id"></select><br>

            <label for="movie">Movie:</label>
            <select id="movie" name="movie_id"></select><br>

            <label for="schedule_time">Schedule Time:</label>
            <input type="datetime-local" id="schedule_time" name="schedule_time"><br>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01"><br>

            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select><br>

            <button type="submit">Save Schedule</button>
            <button type="button" onclick="hideScheduleForm()">Cancel</button>
        </form>
    </div>
    <div id="schedules"></div>

    <script>
        // Fetch and populate room and movie dropdowns
        function populateDropdowns() {
            fetch('/api/admin/rooms')
                .then(response => response.json())
                .then(data => {
                    const roomSelect = document.getElementById('room');
                    roomSelect.innerHTML = '';
                    data.forEach(room => {
                        const option = document.createElement('option');
                        option.value = room.id;
                        option.textContent = room.name;
                        roomSelect.appendChild(option);
                    });
                });

            fetch('/api/admin/movies')
                .then(response => response.json())
                .then(data => {
                    const movieSelect = document.getElementById('movie');
                    movieSelect.innerHTML = '';
                    data.forEach(movie => {
                        const option = document.createElement('option');
                        option.value = movie.id;
                        option.textContent = movie.title;
                        movieSelect.appendChild(option);
                    });
                });
        }

        // Fetch and display schedules
        function fetchSchedules() {
            fetch('/api/admin/schedules')
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('schedules');
                    container.innerHTML = ''; // Clear previous schedules
                    data.forEach(schedule => {
                        const div = document.createElement('div');
                        div.innerHTML = `
                            <p>Movie: ${schedule.movie.title}</p>
                            <p>Room: ${schedule.room.name}</p>
                            <p>Time: ${schedule.schedule_time}</p>
                            <p>Price: $${schedule.price}</p>
                            <p>Status: ${schedule.status}</p>
                            <button onclick="editSchedule(${schedule.id})">Edit</button>
                            <button onclick="deleteSchedule(${schedule.id})">Delete</button>
                        `;
                        container.appendChild(div);
                    });
                });
        }

        fetchSchedules();

        // Show the schedule form
        function showScheduleForm(schedule = null) {
            const form = document.getElementById('schedule-form');
            form.style.display = 'block';

            // Populate dropdowns
            populateDropdowns();

            // If editing, populate form fields
            if (schedule) {
                document.getElementById('schedule-id').value = schedule.id;
                document.getElementById('room').value = schedule.room_id;
                document.getElementById('movie').value = schedule.movie_id;
                document.getElementById('schedule_time').value = schedule.schedule_time;
                document.getElementById('price').value = schedule.price;
                document.getElementById('status').value = schedule.status;
            } else {
                document.getElementById('schedule-form-data').reset();
                document.getElementById('schedule-id').value = '';
            }
        }

        // Hide the schedule form
        function hideScheduleForm() {
            document.getElementById('schedule-form').style.display = 'none';
        }

        // Save (Create or Update) a schedule
        document.getElementById('schedule-form-data').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());
            const scheduleId = document.getElementById('schedule-id').value;

            const method = scheduleId ? 'PUT' : 'POST';
            const endpoint = scheduleId ? `/api/admin/schedules/${scheduleId}` : '/api/admin/schedules';

            fetch(endpoint, {
                method: method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data),
            })
                .then(() => {
                    fetchSchedules(); // Refresh schedule list
                    hideScheduleForm();
                });
        });

        // Edit a schedule
        function editSchedule(id) {
            fetch(`/api/admin/schedules/${id}`)
                .then(response => response.json())
                .then(schedule => {
                    showScheduleForm(schedule);
                });
        }

        // Delete a schedule
        function deleteSchedule(id) {
            fetch(`/api/admin/schedules/${id}`, { method: 'DELETE' })
                .then(() => fetchSchedules());
        }
    </script>
@endsection
