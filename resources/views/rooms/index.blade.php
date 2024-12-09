@extends('layouts.app')

@section('title', 'Room Listing')

@section('content')
    <h1>Available Rooms</h1>
    <div id="rooms"></div>

    <script>
        fetch('/api/rooms')
            .then(response => response.json())
            .then(data => {
                const roomsContainer = document.getElementById('rooms');
                data.forEach(room => {
                    const roomDiv = document.createElement('div');
                    roomDiv.innerHTML = `
                        <h2>${room.name}</h2>
                        <p>Type: ${room.type}</p>
                        <p>${room.description || 'No description available.'}</p>
                        <button onclick="viewSchedules(${room.id})">View Schedules</button>
                    `;
                    roomsContainer.appendChild(roomDiv);
                });
            });

        function viewSchedules(roomId) {
            window.location.href = `/rooms/${roomId}`;
        }
    </script>
@endsection
