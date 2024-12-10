@extends('layouts.app')

@section('title', 'Schedule Management')

@section('content')
    <h1>Schedule Management</h1>

    <!-- Add Schedule Form -->
    <form id="add-schedule-form">
        <h2>Add New Schedule</h2>
        <label for="room_id">Room ID:</label>
        <input type="number" id="room_id" name="room_id" required><br>

        <label for="movie_id">Movie ID:</label>
        <input type="number" id="movie_id" name="movie_id" required><br>

        <label for="schedule_time">Schedule Time:</label>
        <input type="datetime-local" id="schedule_time" name="schedule_time" required><br>

        <label for="price">Price:</label>
        <input type="number" step="0.01" id="price" name="price" required><br>

        <button type="submit">Add Schedule</button>
    </form>

    <!-- Schedules Table -->
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
        // Fetch and display schedules
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
                            <td>${schedule.room_id}</td>
                            <td>${schedule.movie_id}</td>
                            <td>${new Date(schedule.schedule_time).toLocaleString()}</td>
                            <td>$${schedule.price.toFixed(2)}</td>
                            <td>${schedule.status}</td>
                            <td>
                                <button onclick="deleteSchedule(${schedule.id})">Delete</button>
                                <button onclick="editSchedule(${schedule.id})">Edit</button>
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

        // Placeholder for edit schedule logic (can be implemented later)
        function editSchedule(id) {
            alert(`Edit functionality for Schedule ID ${id} will be implemented later.`);
        }

        // Initialize page
        loadSchedules();
    </script>
@endsection
