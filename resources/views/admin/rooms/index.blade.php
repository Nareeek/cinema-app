@extends('layouts.app')

@section('title', 'Room Management')

@section('content')
    <h1>Room Management</h1>

    <!-- Add Room Form -->
    <form id="add-room-form">
        <h2>Add New Room</h2>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="type">Type:</label>
        <input type="text" id="type" name="type" required><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea><br>

        <label for="capacity">Capacity:</label>
        <input type="number" id="capacity" name="capacity" required><br>

        <button type="submit">Add Room</button>
    </form>

    <!-- Rooms Table -->
    <h2>Existing Rooms</h2>
    <table id="rooms-table" border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Type</th>
                <th>Description</th>
                <th>Capacity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <script>
        // Fetch and display rooms
        function loadRooms() {
            fetch('/api/admin/rooms')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.querySelector('#rooms-table tbody');
                    tableBody.innerHTML = ''; // Clear table
                    data.forEach(room => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${room.id}</td>
                            <td>${room.name}</td>
                            <td>${room.type}</td>
                            <td>${room.description || 'N/A'}</td>
                            <td>${room.capacity}</td>
                            <td>
                                <button onclick="deleteRoom(${room.id})">Delete</button>
                                <button onclick="editRoom(${room.id})">Edit</button>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });
                });
        }

        // Handle form submission for adding a new room
        document.getElementById('add-room-form').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());

            fetch('/api/admin/rooms', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data),
            })
                .then(response => {
                    if (response.ok) {
                        alert('Room added successfully!');
                        loadRooms(); // Refresh table
                        this.reset(); // Reset form
                    } else {
                        alert('Failed to add room.');
                    }
                });
        });

        // Delete a room
        function deleteRoom(id) {
            fetch(`/api/admin/rooms/${id}`, {
                method: 'DELETE',
            })
                .then(response => {
                    if (response.ok) {
                        alert('Room deleted successfully!');
                        loadRooms(); // Refresh table
                    } else {
                        alert('Failed to delete room.');
                    }
                });
        }

        // Placeholder for edit room logic (can be implemented later)
        function editRoom(id) {
            alert(`Edit functionality for Room ID ${id} will be implemented later.`);
        }

        // Initialize page
        loadRooms();
    </script>
@endsection
