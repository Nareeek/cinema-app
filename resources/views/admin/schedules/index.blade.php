@extends('layouts.app')

@section('title', 'Schedule Management')

@section('content')
    <h1>Schedule Management</h1>
    <button onclick="createSchedule()">Add New Schedule</button>
    <div id="schedules"></div>

    <script>
        fetch('/api/admin/schedules')
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('schedules');
                data.forEach(schedule => {
                    const div = document.createElement('div');
                    div.innerHTML = `
                        <p>Movie: ${schedule.movie.title}</p>
                        <p>Room: ${schedule.room.name}</p>
                        <p>Time: ${schedule.schedule_time}</p>
                        <button onclick="editSchedule(${schedule.id})">Edit</button>
                        <button onclick="deleteSchedule(${schedule.id})">Delete</button>
                    `;
                    container.appendChild(div);
                });
            });

        function createSchedule() {
            alert('Redirect to schedule creation form');
        }

        function editSchedule(id) {
            alert('Redirect to edit form for schedule ' + id);
        }

        function deleteSchedule(id) {
            alert('Delete schedule with id ' + id);
        }
    </script>
@endsection
