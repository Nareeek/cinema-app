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

        // Render seat numbers in header
        for (let i = 1; i <= maxSeats; i++) {
            const seatNumberHeader = document.createElement("div");
            seatNumberHeader.textContent = i;
            seatNumberHeader.className = "seat-header-number";
            seatHeader.appendChild(seatNumberHeader);
        }

        // Group seats by rows
        const rows = {};
        seatsData.forEach(seat => {
            if (!rows[seat.row_number]) {
                rows[seat.row_number] = [];
            }
            rows[seat.row_number].push(seat);
        });

        // Render rows and seats
        Object.keys(rows).forEach(rowNumber => {
            const row = document.createElement("div");
            row.className = "seat-row";

            // Add row number
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

    // Toggle seat selection
    function toggleSeatSelection(seatDiv) {
        const seatId = seatDiv.dataset.id;
        const price = parseFloat(seatDiv.dataset.price) || 0;

        if (seatDiv.classList.contains("selected")) {
            // Deselect seat
            seatDiv.classList.remove("selected");
            selectedSeats = selectedSeats.filter(seat => seat.id != seatId);
            totalPrice -= price;
        } else {
            // Select seat
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
        validateForm(); // Validate form on seat selection
    }

    // Update booking summary
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
            validateForm(); // Validate form on seat removal
        }
    }

    // Show popup alert
    function showPopup(message) {
        const popup = document.createElement("div");
        popup.className = "popup";
        popup.textContent = message;

        document.body.appendChild(popup);

        // Remove popup after 3 seconds
        setTimeout(() => {
            popup.remove();
        }, 3000);
    }

    // Validate form inputs
    function validateForm() {
        const email = emailInput.value.trim();
        const phone = phoneInput.value.trim();

        const isValidEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        const isValidPhone = /^\d{10,15}$/.test(phone);

        // Enable the button only if all conditions are met
        continueBtn.disabled = !(selectedSeats.length > 0 && isValidEmail && isValidPhone);
    }

    // Handle continue button click
    continueBtn.addEventListener("click", () => {
        const email = emailInput.value.trim();
        const phone = phoneInput.value.trim();

        if (!email || !phone) {
            showPopup("Please fill in both email and phone fields.");
            return;
        }

        if (!validateEmail(email)) {
            showPopup("Please enter a valid email address.");
            return;
        }

        if (!validatePhone(phone)) {
            showPopup("Please enter a valid phone number.");
            return;
        }

        if (selectedSeats.length > 0 && email && phone) {
            // Redirect to payment page with seat data
            const queryParams = new URLSearchParams({
                selected_seats: JSON.stringify(selectedSeats.map(seat => seat.seat)),
                total_price: totalPrice
            }).toString();

            window.location.href = `/payment?${queryParams}`;
        }
    });

    // Email validation
    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Phone validation
    function validatePhone(phone) {
        const phoneRegex = /^\d{10,15}$/; // Only digits, 10-15 characters
        return phoneRegex.test(phone);
    }

    // Attach input listeners for validation
    emailInput.addEventListener("input", validateForm);
    phoneInput.addEventListener("input", validateForm);

    // Initialize page
    loadSeats();
});
