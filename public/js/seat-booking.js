const scheduleId = 1; // Replace with dynamic schedule ID

// Fetch seat availability
function loadSeats() {
    fetch(`/api/schedules/${scheduleId}/seats`)
        .then(response => response.json())
        .then(data => renderSeatGrid(data));
}

// Render the seat grid
function renderSeatGrid(seats) {
    const seatGrid = document.getElementById('seat-grid');
    seatGrid.innerHTML = '';

    const rows = [...new Set(seats.map(seat => seat.row_number))];
    rows.forEach(row => {
        const rowDiv = document.createElement('div');
        rowDiv.className = 'row';

        seats.filter(seat => seat.row_number === row).forEach(seat => {
            const seatButton = document.createElement('button');
            seatButton.textContent = `R${seat.row_number}-S${seat.seat_number}`;
            seatButton.className = seat.is_booked ? 'seat booked' : 'seat available';
            seatButton.disabled = seat.is_booked;

            seatButton.addEventListener('click', () => toggleSeatSelection(seat));
            rowDiv.appendChild(seatButton);
        });

        seatGrid.appendChild(rowDiv);
    });
}

// Manage selected seats
let selectedSeats = [];
function toggleSeatSelection(seat) {
    const seatIndex = selectedSeats.findIndex(s => s.id === seat.id);
    if (seatIndex === -1) {
        selectedSeats.push(seat);
    } else {
        selectedSeats.splice(seatIndex, 1);
    }
    updateBookingSummary();
}

// Update booking summary
function updateBookingSummary() {
    const selectedSeatsList = selectedSeats.map(seat => `R${seat.row_number}-S${seat.seat_number}`);
    document.getElementById('selected-seats').textContent = selectedSeatsList.join(', ');

    const totalPrice = selectedSeats.reduce((sum, seat) => sum + seat.price, 0);
    document.getElementById('total-price').textContent = totalPrice.toFixed(2);
}

// Confirm booking
document.getElementById('confirm-booking').addEventListener('click', () => {
    const bookings = selectedSeats.map(seat => ({
        seat_id: seat.id,
        user_email: 'test@example.com', // Replace with user input
        user_phone: '1234567890', // Replace with user input
        status: 'Pending',
    }));

    Promise.all(
        bookings.map(booking =>
            fetch(`/api/schedules/${scheduleId}/book`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(booking),
            })
        )
    ).then(() => {
        alert('Booking confirmed!');
        loadSeats(); // Refresh seat grid
        selectedSeats = [];
        updateBookingSummary(); // Clear summary
    });
});

// Initialize page
loadSeats();
