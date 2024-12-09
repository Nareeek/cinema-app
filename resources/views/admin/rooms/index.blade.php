@extends('layouts.app')

@section('title', 'Room Management')

@section('content')
    <h1>Room Management</h1>
    <button onclick="showRoomForm()">Add New Room</button>
    <div id="room-form" style="display: none;">
        <form id="room-form-data">
            <input type="hidden" id="room-id">
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
        function showRoomForm(room = null) {
            const form = document.getElementById('room-form');
            form.style.display = 'block';

            // If editing, populate form fields
            if (room) {
                document.getElementById('room-id').value = room.id;
                document.getElementById('name').value = room.name;
                document.getElementById('type').value = room.type;
                document.getElementById('description').value = room.description;
                document.getElementById('capacity').value = room.capacity;
            } else {
                document.getElementById('room-form-data').reset();
                document.getElementById('room-id').value = '';
            }
        }

        // Hide the room form
        function hideRoomForm() {
            document.getElementById('room-form').style.display = 'none';
        }

        // Save (Create or Update) a room
        document.getElementById('room-form-data').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());
            const roomId = document.getElementById('room-id').value;

            const method = roomId ? 'PUT' : 'POST';
            const endpoint = roomId ? `/api/admin/rooms/${roomId}` : '/api/admin/rooms';

            fetch(endpoint, {
                method: method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data),
            })
                .then(() => {
                    fetchRooms(); // Refresh room list
                    hideRoomForm();
                });
        });

        // Edit a room
        function editRoom(id) {
            fetch(`/api/admin/rooms/${id}`)
                .then(response => response.json())
                .then(room => {
                    showRoomForm(room);
                });
        }

        // Delete a room
        function deleteRoom(id) {
            fetch(`/api/admin/rooms/${id}`, { method: 'DELETE' })
                .then(() => fetchRooms());
        }
    </script>
@endsection
