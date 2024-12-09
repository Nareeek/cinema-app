@extends('layouts.app')

@section('title', 'Schedule Management')

@section('content')
    <h1>Schedules</h1>
    <div id="schedules"></div>

    <script>
        fetch('/api/schedules')
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('schedules');
                data.forEach(schedule => {
                    const div = document.createElement('div');
                    div.innerHTML = `
                        <h2>${schedule.movie.title}</h2>
                        <p>Room: ${schedule.room.name}</p>
                        <p>Time: ${schedule.schedule_time}</p>
                    `;
                    container.appendChild(div);
                });
            });
    </script>
@endsection
