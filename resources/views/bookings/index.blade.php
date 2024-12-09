@extends('layouts.app')

@section('title', 'Seat Booking')

@section('content')
    <h1>Book Your Seat</h1>
    <div id="seat-grid"></div>
    <div id="booking-summary"></div>

    <script>
        const scheduleId = {{ $id }};
        let selectedSeats = [];

        fetch(`/api/schedules/${scheduleId}/seats`)
            .then(response => response.json())
            .then(seats => {
                const seatGrid = document.getElementById('seat-grid');
                seats.forEach(seat => {
                    const seatDiv = document.createElement('div');
                    seatDiv.textContent = `Row: ${seat.row_number}, Seat: ${seat.seat_number}`;
                    seatDiv.className = seat.is_booked ? 'seat booked' : 'seat available';
                    seatDiv.onclick = () => selectSeat(seat.id);
                    seatGrid.appendChild(seatDiv);
                });
            });

        function selectSeat(seatId) {
            if (!selectedSeats.includes(seatId)) {
                selectedSeats.push(seatId);
            } else {
                selectedSeats = selectedSeats.filter(id => id !== seatId);
            }
            updateBookingSummary();
        }

        function updateBookingSummary() {
            const bookingSummary = document.getElementById('booking-summary');
            bookingSummary.innerHTML = `
                <h2>Booking Summary</h2>
                <p>Selected Seats: ${selectedSeats.join(', ')}</p>
                <button onclick="confirmBooking()">Confirm Booking</button>
            `;
        }

        function confirmBooking() {
            fetch(`/api/schedules/${scheduleId}/book`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ seat_id: selectedSeats[0], user_email: 'test@example.com', user_phone: '1234567890' })
            })
            .then(response => response.json())
            .then(data => {
                alert('Booking confirmed!');
                window.location.href = '/';
            });
        }
    </script>
@endsection
