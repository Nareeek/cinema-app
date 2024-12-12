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

    let selectedSeats = [];
    let totalPrice = 0;

    // Fetch and load seats
    function loadSeats() {
        fetch(`/api/schedules/${scheduleId}/seats`)
            .then(res => res.json())
            .then(renderSeatGrid)
            .catch(err => console.error("Error loading seats:", err));
    }

    // Render seat grid dynamically
    function renderSeatGrid(seats) {
        seats.forEach(seat => {
            const seatDiv = document.createElement("div");
            seatDiv.textContent = `R${seat.row_number}-S${seat.seat_number}`;
            seatDiv.className = `seat ${seat.is_booked ? "booked" : "available"}`;
            seatDiv.dataset.id = seat.id; // Correctly set data-id
            seatDiv.dataset.row = seat.row_number;
            seatDiv.dataset.seat = seat.seat_number;
            seatDiv.dataset.price = seat.price;
        
            if (!seat.is_booked) {
                seatDiv.addEventListener("click", () => toggleSeatSelection(seatDiv));
            }
    
            seatGrid.appendChild(seatDiv);
        });
    }

    // Handle seat selection
    function toggleSeatSelection(seatDiv) {
        const seatId = seatDiv.dataset.id;
        const price = parseFloat(seatDiv.dataset.price) || 0; // Ensure price is a number
    
        if (seatDiv.classList.contains("selected")) {
            // Deselect seat
            seatDiv.classList.remove("selected");
            selectedSeats = selectedSeats.filter(seat => seat.id != seatId);
            totalPrice -= price; // Deduct price from total
        } else {
            // Select seat
            seatDiv.classList.add("selected");
            selectedSeats.push({
                id: seatId,
                row: seatDiv.dataset.row,
                seat: seatDiv.dataset.seat,
                price: price, // Add price to selected seat object
            });
            totalPrice += price; // Add price to total
        }
    
        updateSummary();
    }
    
    // Update booking summary table
    function updateSummary() {
        summaryTable.innerHTML = ''; // Clear previous table content
    
        selectedSeats.forEach(seat => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${seat.row}</td>
                <td>${seat.seat}</td>
                <td>$${seat.price.toFixed(2)}</td>
                <td><button class="remove-seat-btn">X</button></td>
            `;
    
            // Append the row to the summary table
            summaryTable.appendChild(row);
    
            // Attach an event listener to the "X" button
            const removeBtn = row.querySelector(".remove-seat-btn");
            removeBtn.addEventListener("click", () => {
                removeSeat(seat.id); // Pass the seat ID to removeSeat
            });
        });
    
        totalPriceElement.textContent = totalPrice.toFixed(2); // Update total price
    }
    

    // Validate form and enable/disable Continue button
    function validateForm() {
        continueBtn.disabled = !(
            selectedSeats.length > 0 &&
            emailInput.value &&
            phoneInput.value
        );
    }

    function removeSeat(seatId) {
        const seat = selectedSeats.find(seat => String(seat.id) === String(seatId));
    
        if (seat) {
            const seatDiv = document.querySelector(`.seat[data-id='${seatId}']`);
            if (seatDiv) {
                seatDiv.classList.remove("selected");
            }
    
            // Remove the seat from selectedSeats
            selectedSeats = selectedSeats.filter(s => String(s.id) !== String(seatId));
            totalPrice -= seat.price;
    
            updateSummary(); // Refresh the summary table
        } else {
            console.warn(`Seat with ID ${seatId} not found in selectedSeats.`);
        }
    }
    

    emailInput.addEventListener("input", validateForm);
    phoneInput.addEventListener("input", validateForm);

    // Initialize page
    loadSeats();
});
