@extends('layouts.app')

@section('title', 'Room Management')

@section('content')
    <h1>Room Management</h1>
    <button onclick="createRoom()">Add New Room</button>
    <div id="rooms"></div>

    <script>
        // Fetch and display rooms
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
                        <button onclick="viewSchedules(${room.id}, this)">View Schedules</button>
                        <div class="schedules" style="display: none;"></div>
                        <button onclick="editRoom(${room.id})">Edit</button>
                        <button onclick="deleteRoom(${room.id})">Delete</button>
                    `;
                    container.appendChild(div);
                });
            });

        // Fetch and display schedules for the room
        function viewSchedules(roomId, button) {
            const schedulesDiv = button.nextElementSibling;
            if (schedulesDiv.style.display === 'none') {
                fetch(`/api/rooms/${roomId}/schedules`)
                    .then(response => response.json())
                    .then(schedules => {
                        schedulesDiv.innerHTML = schedules.map(schedule => `
                            <p>Movie: ${schedule.movie.title} at ${schedule.schedule_time}</p>
                        `).join('');
                        schedulesDiv.style.display = 'block';
                    });
            } else {
                schedulesDiv.style.display = 'none'; // Collapse if already open
            }
        }

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
