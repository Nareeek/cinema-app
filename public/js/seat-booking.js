// Define selectedSeats and totalPrice globally
let selectedSeats = [];
let totalPrice = 0;

document.addEventListener("DOMContentLoaded", () => {
    const bookingData = document.getElementById("booking-data");

    if (!bookingData) {
        console.error("Booking data element not found!");
        return;
    }

    const scheduleId = bookingData.dataset.scheduleId;
    const roomId = bookingData.dataset.roomId;
    const movieId = bookingData.dataset.movieId;
    const seatGrid = document.getElementById("seat-grid");
    const seatHeader = document.getElementById("seat-header");
    const summaryTable = document.getElementById("summary-table");
    const totalPriceElement = document.getElementById("total-price");
    const continueBtn = document.getElementById("continue-btn");
    const emailInput = document.getElementById("email");
    const phoneInput = document.getElementById("phone");

    // Fetch and load seats dynamically
    function loadSeats() {
        fetch(`/api/schedules/${scheduleId}/seats`)
            .then(response => response.json())
            .then(data => {
                console.log("Fetched seat data:", data);
                renderCoolSeats(data);
            })
            .catch(error => console.error("Error loading seats:", error));
    }

    // Render seat grid dynamically
    function renderCoolSeats(seatsData) {
        seatHeader.innerHTML = ""; // Clear the seat header
        seatGrid.innerHTML = ""; // Clear the seat grid

        const maxSeats = Math.max(...seatsData.map(seat => seat.seat_number)); // Find the maximum seat number

        // Render seat numbers in the header
        for (let i = 1; i <= maxSeats; i++) {
            const seatNumberHeader = document.createElement("div");
            seatNumberHeader.textContent = i;
            seatNumberHeader.className = "seat-header-number";
            seatHeader.appendChild(seatNumberHeader);
        }

        // Group seats by row
        const rows = {};
        seatsData.forEach(seat => {
            if (!rows[seat.row_number]) {
                rows[seat.row_number] = [];
            }
            rows[seat.row_number].push(seat);
        });

        // Render each row and its seats
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
                    // Allow selection for available seats
                    seatDiv.addEventListener("click", () => toggleSeatSelection(seatDiv));
                } else {
                    // Tooltip for booked seats
                    seatDiv.title = "This seat is already booked";
                }

                row.appendChild(seatDiv);
            });

            seatGrid.appendChild(row);
        });
    }

    // Toggle seat selection
    function toggleSeatSelection(seatDiv) {
        const seatId = seatDiv.dataset.id;
        const price = parseFloat(seatDiv.dataset.price) || 0;

        if (seatDiv.classList.contains("selected")) {
            // Deselect seat
            seatDiv.classList.remove("selected");
            selectedSeats = selectedSeats.filter(seat => String(seat.id) !== String(seatId));
            totalPrice -= price;
        } else {
            // Select seat
            if (!selectedSeats.some(seat => String(seat.id) === String(seatId))) {
                seatDiv.classList.add("selected");
                selectedSeats.push({
                    id: seatId,
                    row: seatDiv.dataset.row,
                    seat: seatDiv.dataset.seat,
                    price: price,
                });
                totalPrice += price;
            }
        }

        updateSummary();
        validateForm(); // Validate form on seat selection
    }

    // Update booking summary
    function updateSummary() {
        summaryTable.innerHTML = ""; // Clear the summary table
        let newTotal = 0;

        selectedSeats.forEach(seat => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${seat.row}</td>
                <td>${seat.seat}</td>
                <td>${seat.price.toFixed(2)}</td>
                <td><button class="remove-seat-btn" data-id="${seat.id}">X</button></td>
            `;
            summaryTable.appendChild(row);

            newTotal += seat.price;
        });

        totalPrice = newTotal;
        totalPriceElement.textContent = totalPrice.toFixed(2);

        // Add remove seat functionality
        document.querySelectorAll(".remove-seat-btn").forEach(button => {
            button.addEventListener("click", () => {
                const seatId = button.dataset.id;
                removeSeat(seatId);
            });
        });
    }

    // Remove seat from selection
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
            validateForm();
        }
    }

    // Validate form inputs
    function validateForm() {
        const email = emailInput.value.trim();
        const phone = phoneInput.value.trim();

        const isValidEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        const isValidPhone = /^\d{10,15}$/.test(phone);

        // Enable the continue button only if all conditions are met
        continueBtn.disabled = !(selectedSeats.length > 0 && isValidEmail && isValidPhone);
    }

    // Handle continue button click
    continueBtn.addEventListener("click", () => {
        if (selectedSeats.length === 0 || !emailInput.value || !phoneInput.value) {
            alert("Please select seats and provide contact details.");
            return;
        }

        // Redirect to payment page with booking data
        fetch('/payment', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({
                schedule_id: scheduleId,
                selected_seats: selectedSeats,
                total_price: totalPrice,
            }),
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                // Redirect on success
                window.location.href = '/payment';
            })
            .catch(error => {
                console.error("Error redirecting to payment:", error);
                alert("An error occurred while redirecting to the payment page. Please try again.");
            });
    });

    // Attach input listeners for validation
    emailInput.addEventListener("input", validateForm);
    phoneInput.addEventListener("input", validateForm);

    // Initialize page
    loadSeats();
});
