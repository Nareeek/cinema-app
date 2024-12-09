@extends('layouts.app')

@section('title', 'Schedule Management')

@section('content')
    <h1>Schedule Management</h1>

    <!-- Add Schedule Form -->
    <form id="add-schedule-form">
        <h2>Add New Schedule</h2>
        <label for="room_id">Room:</label>
        <select id="room_id" name="room_id" required></select><br>

        <label for="movie_id">Movie:</label>
        <select id="movie_id" name="movie_id" required></select><br>

        <label for="schedule_time">Schedule Time:</label>
        <input type="datetime-local" id="schedule_time" name="schedule_time" required><br>

        <label for="price">Price:</label>
        <input type="number" step="0.01" id="price" name="price" required><br>

        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
        </select><br>

        <button type="submit">Add Schedule</button>
    </form>

    <!-- Schedule Table -->
    <h2>Existing Schedules</h2>
    <table id="schedules-table" border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Room</th>
                <th>Movie</th>
                <th>Time</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <script>
        // Fetch and populate data for rooms and movies in dropdowns
        function populateDropdowns() {
            fetch('/api/admin/rooms')
                .then(response => response.json())
                .then(data => {
                    const roomSelect = document.getElementById('room_id');
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
                    const movieSelect = document.getElementById('movie_id');
                    data.forEach(movie => {
                        const option = document.createElement('option');
                        option.value = movie.id;
                        option.textContent = movie.title;
                        movieSelect.appendChild(option);
                    });
                });
        }

        // Fetch and display schedules in the table
        function loadSchedules() {
            fetch('/api/admin/schedules')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.querySelector('#schedules-table tbody');
                    tableBody.innerHTML = ''; // Clear table
                    data.forEach(schedule => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${schedule.id}</td>
                            <td>${schedule.room.name}</td>
                            <td>${schedule.movie.title}</td>
                            <td>${schedule.schedule_time}</td>
                            <td>${schedule.price}</td>
                            <td>${schedule.status}</td>
                            <td>
                                <button onclick="deleteSchedule(${schedule.id})">Delete</button>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });
                });
        }

        // Handle form submission for adding a new schedule
        document.getElementById('add-schedule-form').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());

            fetch('/api/admin/schedules', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data),
            })
                .then(response => {
                    if (response.ok) {
                        alert('Schedule added successfully!');
                        loadSchedules(); // Refresh table
                        this.reset(); // Reset form
                    } else {
                        alert('Failed to add schedule.');
                    }
                });
        });

        // Delete a schedule
        function deleteSchedule(id) {
            fetch(`/api/admin/schedules/${id}`, {
                method: 'DELETE',
            })
                .then(response => {
                    if (response.ok) {
                        alert('Schedule deleted successfully!');
                        loadSchedules(); // Refresh table
                    } else {
                        alert('Failed to delete schedule.');
                    }
                });
        }

        // Initialize the page
        populateDropdowns();
        loadSchedules();
    </script>
@endsection
