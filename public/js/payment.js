document.addEventListener("DOMContentLoaded", () => {
    const paymentData = document.getElementById("payment-data");

    if (!paymentData) {
        console.error("Payment data element not found!");
        return;
    }

    const selectedSeats = JSON.parse(paymentData.dataset.selectedSeats || "[]");
    const totalPrice = parseFloat(paymentData.dataset.totalPrice || "0");
    const scheduleId = paymentData.dataset.scheduleId;

    // Populate booking summary
    const seatsElement = document.getElementById("selected-seats");
    const totalPriceElement = document.getElementById("total-price");
    const paymentMethods = document.querySelectorAll(".payment-method");
    const confirmPaymentBtn = document.getElementById("confirm-payment-btn");

    // Validate essential elements
    if (!seatsElement || !totalPriceElement || !confirmPaymentBtn || paymentMethods.length === 0) {
        console.error("One or more required elements are missing from the DOM.");
        return;
    }

    let selectedPaymentMethod = null;

    // Display selected seats and total price
    const groupedSeats = selectedSeats.reduce((acc, seat) => {
        // Group seats by rows
        if (!acc[seat.row]) acc[seat.row] = [];
        acc[seat.row].push(seat.seat);
        return acc;
    }, {});

    // Generate the display text
    seatsElement.innerHTML =
        Object.keys(groupedSeats).length > 0
            ? Object.entries(groupedSeats)
                .map(([row, seats]) => `<span class="seat-badge">Row ${row} -> Seat ${seats.join(", ")}</span>`)
                .join("")
            : "<span class='no-seats'>No seats selected.</span>";
    totalPriceElement.textContent = `$${totalPrice.toFixed(2)}`;

    // Disable the confirm button initially
    confirmPaymentBtn.disabled = true;

    // Handle payment method selection
    paymentMethods.forEach((method) => {
        method.addEventListener("click", () => {
            // Remove "selected" class from all methods
            paymentMethods.forEach((m) => m.classList.remove("selected"));

            // Add "selected" class to the clicked method
            method.classList.add("selected");

            // Store the selected method
            selectedPaymentMethod = method.dataset.method;

            // Enable the confirm button if a payment method is selected
            confirmPaymentBtn.disabled = false;
        });
    });

    // Handle payment confirmation
    confirmPaymentBtn.addEventListener("click", async () => {
        if (!selectedPaymentMethod) {
            alert("Please select a payment method.");
            return;
        }

        // Check seat availability before proceeding with payment
        const availabilityResponse = await checkSeatsBeforePayment(selectedSeats);

        if (!availabilityResponse.success) {
            if (availabilityResponse.unavailable_seats) {
                alert("Some seats are already booked. You will be redirected to the booking page to choose different seats.");
                const redirectScheduleId = availabilityResponse.schedule_id || scheduleId; // Use a new variable for clarity
                window.location.href = `/bookings/${redirectScheduleId}`; // Redirect to the specific booking page
            } else {
                alert(availabilityResponse.message || "An error occurred while checking seat availability.");
            }
            return; // Stop further execution
        }

        // Proceed with payment
        fetch("/api/confirm-booking", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({
                selected_seats: selectedSeats,
                schedule_id: scheduleId,
                total_price: totalPrice,
                payment_method: selectedPaymentMethod,
            }),
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then((data) => {
                if (data.success) {
                    window.location.href = "/bookings/success"; // Redirect to success page
                } else {
                    console.error("Booking confirmation failed:", data.message);
                    alert(data.message || "Booking confirmation failed. Please try again.");
                }
            })
            .catch((error) => {
                console.error("Error confirming booking:", error);
                alert("An error occurred. Please try again.");
            });
    });

    function checkSeatsBeforePayment(selectedSeats) {
        return fetch("/check-seats-before-payment", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ selected_seats: selectedSeats.map(seat => seat.id) }),
        })
            .then(response => response.json())
            .catch(error => {
                console.error("Error checking seat availability:", error);
                return { success: false, message: "An error occurred while checking seats." };
            });
    }
});
