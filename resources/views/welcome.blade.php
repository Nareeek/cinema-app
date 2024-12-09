@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
    <h1>Welcome to Cinema App</h1>
    <h2>Available Rooms</h2>
    <div id="rooms"></div>

    <script>
        fetch('/api/rooms')
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('rooms');
                data.forEach(room => {
                    const div = document.createElement('div');
                    div.innerHTML = `
                        <h2>${room.name}</h2>
                        <p>Type: ${room.type}</p>
                        <p>${room.description || 'No description available.'}</p>
                        <button onclick="viewSchedules(${room.id}, this)">View Schedules</button>
                        <div class="schedules" style="display: none;"></div>
                    `;
                    container.appendChild(div);
                });
            });

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
    </script>
@endsection
