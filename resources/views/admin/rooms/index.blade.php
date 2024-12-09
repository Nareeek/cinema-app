@extends('layouts.app')

@section('title', 'Room Management')

@section('content')
    <h1>Room Management</h1>
    <button onclick="showRoomForm()">Add New Room</button>
    <div id="room-form" style="display: none;">
        <form id="create-room-form">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br>

            <label for="type">Type:</label>
            <input type="text" id="type" name="type" required><br>

            <label for="description">Description:</label>
            <textarea id="description" name="description"></textarea><br>

            <label for="capacity">Capacity:</label>
            <input type="number" id="capacity" name="capacity" required><br>

            <button type="submit">Save Room</button>
            <button type="button" onclick="hideRoomForm()">Cancel</button>
        </form>
    </div>
    <div id="rooms"></div>

    <script>
        // Fetch and display all rooms
        function fetchRooms() {
            fetch('/api/admin/rooms')
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('rooms');
                    container.innerHTML = ''; // Clear previous content
                    data.forEach(room => {
                        const div = document.createElement('div');
                        div.innerHTML = `
                            <h2>${room.name}</h2>
                            <p>Type: ${room.type}</p>
                            <p>Description: ${room.description || 'No description'}</p>
                            <p>Capacity: ${room.capacity}</p>
                            <button onclick="editRoom(${room.id})">Edit</button>
                            <button onclick="deleteRoom(${room.id})">Delete</button>
                        `;
                        container.appendChild(div);
                    });
                });
        }

        fetchRooms();

        // Show the room form
        function showRoomForm() {
            document.getElementById('room-form').style.display = 'block';
        }

        // Hide the room form
        function hideRoomForm() {
            document.getElementById('room-form').style.display = 'none';
        }

        // Create a new room
        document.getElementById('create-room-form').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());

            fetch('/api/admin/rooms', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data),
            })
                .then(() => {
                    fetchRooms(); // Refresh room list
                    hideRoomForm();
                });
        });

        // Delete a room
        function deleteRoom(id) {
            fetch(`/api/admin/rooms/${id}`, { method: 'DELETE' })
                .then(() => fetchRooms());
        }

        // Placeholder for editing (future implementation)
        function editRoom(id) {
            alert('Editing rooms is not yet implemented!');
        }
    </script>
@endsection
