@extends('layouts.app')

@section('title', 'Room Management')

@section('content')
    <h1>Room Management</h1>
    <button onclick="createRoom()">Add New Room</button>
    <div id="rooms"></div>

    <script>
        // Fetch all rooms and display them
        fetch('/api/admin/rooms')
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('rooms');
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

        function createRoom() {
            alert('Redirect to room creation form');
        }

        function editRoom(id) {
            alert('Redirect to edit form for room ' + id);
        }

        function deleteRoom(id) {
            alert('Delete room with id ' + id);
        }
    </script>
@endsection
