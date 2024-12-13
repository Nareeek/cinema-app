// Define selectedSeats and totalPrice globally
let selectedSeats = [];
let totalPrice = 0;

document.addEventListener("DOMContentLoaded", () => {
    const seatGrid = document.getElementById("seat-grid");
    const summaryTable = document.getElementById("summary-table");
    const totalPriceElement = document.getElementById("total-price");
    const continueBtn = document.getElementById("continue-btn");
    const emailInput = document.getElementById("email");
    const phoneInput = document.getElementById("phone");

    // Fetch and load seats
    function loadSeats() {
        fetch(`/api/schedules/${scheduleId}/seats`)
            .then(response => response.json())
            .then(data => renderCoolSeats(data))
            .catch(error => console.error("Error loading seats:", error));
    }

    // Render seat grid dynamically
    function renderCoolSeats(seatsData) {
        const seatHeader = document.getElementById("seat-header");
        const seatGrid = document.getElementById("seat-grid");

        seatHeader.innerHTML = "";
        seatGrid.innerHTML = "";

        const maxSeats = Math.max(...seatsData.map(seat => seat.seat_number));

        for (let i = 1; i <= maxSeats; i++) {
            const seatNumberHeader = document.createElement("div");
            seatNumberHeader.textContent = i;
            seatNumberHeader.className = "seat-header-number";
            seatHeader.appendChild(seatNumberHeader);
        }

        const rows = {};
        seatsData.forEach(seat => {
            if (!rows[seat.row_number]) {
                rows[seat.row_number] = [];
            }
            rows[seat.row_number].push(seat);
        });

        Object.keys(rows).forEach(rowNumber => {
            const row = document.createElement("div");
            row.className = "seat-row";

            const rowNumberDiv = document.createElement("div");
            rowNumberDiv.className = "row-number";
            rowNumberDiv.textContent = `Row ${rowNumber}`;
            row.appendChild(rowNumberDiv);

            rows[rowNumber].forEach(seat => {
                const seatDiv = document.createElement("div");
                seatDiv.className = `seat ${seat.is_booked ? "booked" : "available"}`;
                seatDiv.dataset.id = seat.id;
                seatDiv.dataset.row = seat.row_number;
                seatDiv.dataset.seat = seat.seat_number;
                seatDiv.dataset.price = seat.price || 0;

                if (!seat.is_booked) {
                    seatDiv.addEventListener("click", () => toggleSeatSelection(seatDiv));
                }

                row.appendChild(seatDiv);
            });

            seatGrid.appendChild(row);
        });
    }

    function toggleSeatSelection(seatDiv) {
        const seatId = seatDiv.dataset.id;
        const price = parseFloat(seatDiv.dataset.price) || 0;

        if (seatDiv.classList.contains("selected")) {
            seatDiv.classList.remove("selected");
            selectedSeats = selectedSeats.filter(seat => seat.id != seatId);
            totalPrice -= price;
        } else {
            seatDiv.classList.add("selected");
            selectedSeats.push({
                id: seatId,
                row: seatDiv.dataset.row,
                seat: seatDiv.dataset.seat,
                price: price,
            });
            totalPrice += price;
        }

        updateSummary();
    }

    function updateSummary() {
        summaryTable.innerHTML = '';
        let newTotal = 0;

        selectedSeats.forEach(seat => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${seat.row}</td>
                <td>${seat.seat}</td>
                <td>$${seat.price.toFixed(2)}</td>
                <td><button class="remove-seat-btn" data-id="${seat.id}">X</button></td>
            `;
            summaryTable.appendChild(row);

            newTotal += seat.price;
        });

        totalPrice = newTotal;
        totalPriceElement.textContent = totalPrice.toFixed(2);

        document.querySelectorAll(".remove-seat-btn").forEach(button => {
            button.addEventListener("click", () => {
                const seatId = button.dataset.id;
                removeSeat(seatId);
            });
        });
    }

    function removeSeat(seatId) {
        const seat = selectedSeats.find(seat => String(seat.id) === String(seatId));

        if (seat) {
            const seatDiv = document.querySelector(`.seat[data-id='${seatId}']`);
            if (seatDiv) {
                seatDiv.classList.remove("selected");
            }

            selectedSeats = selectedSeats.filter(s => String(s.id) !== String(seatId));
            totalPrice -= seat.price;

            updateSummary();
        }
        // else {
        //     console.warn(`Seat with ID ${seatId} not found in selectedSeats.`);
        // }
    }

    function validateForm() {
        continueBtn.disabled = !(
            selectedSeats.length > 0 &&
            emailInput.value.trim() !== "" &&
            phoneInput.value.trim() !== ""
        );
    }

    emailInput.addEventListener("input", validateForm);
    phoneInput.addEventListener("input", validateForm);

    loadSeats();
});
