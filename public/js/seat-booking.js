document.addEventListener("DOMContentLoaded", () => {
    const seatGrid = document.getElementById("seat-grid");
    const summaryTable = document.getElementById("summary-table");
    const totalPriceElement = document.getElementById("total-price");
    const continueBtn = document.getElementById("continue-btn");
    const emailInput = document.getElementById("email");
    const phoneInput = document.getElementById("phone");

    let selectedSeats = [];
    let totalPrice = 0;

    // Load seats (fetch from API)
    function loadSeats() {
        fetch(`/api/schedules/${scheduleId}/seats`)
            .then(res => res.json())
            .then(renderSeatGrid);
    }

    // Render seat grid
    function renderSeatGrid(seats) {
        seatGrid.innerHTML = '';
        seats.forEach(seat => {
            const seatDiv = document.createElement("div");
            seatDiv.textContent = `R${seat.row_number}-S${seat.seat_number}`;
            seatDiv.className = `seat ${seat.is_booked ? "booked" : "available"}`;
            seatDiv.addEventListener("click", () => toggleSeatSelection(seat));
            seatGrid.appendChild(seatDiv);
        });
    }

    // Toggle seat selection
    function toggleSeatSelection(seat) {
        if (seat.is_booked) return;

        const isSelected = selectedSeats.find(s => s.id === seat.id);
        if (isSelected) {
            selectedSeats = selectedSeats.filter(s => s.id !== seat.id);
            totalPrice -= seat.price;
        } else {
            selectedSeats.push(seat);
            totalPrice += seat.price;
        }

        updateSummary();
    }

    // Update summary table
    function updateSummary() {
        summaryTable.innerHTML = '';
        selectedSeats.forEach(seat => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${seat.row_number}</td>
                <td>${seat.seat_number}</td>
                <td>${seat.price}</td>
                <td><button onclick="removeSeat(${seat.id})">X</button></td>
            `;
            summaryTable.appendChild(row);
        });

        totalPriceElement.textContent = totalPrice.toFixed(2);
        validateForm();
    }

    // Form validation
    function validateForm() {
        continueBtn.disabled = !(
            selectedSeats.length > 0 &&
            emailInput.value &&
            phoneInput.value
        );
    }

    emailInput.addEventListener("input", validateForm);
    phoneInput.addEventListener("input", validateForm);

    // Load seats initially
    loadSeats();
});
