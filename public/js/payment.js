document.addEventListener("DOMContentLoaded", () => {
    const paymentData = document.getElementById("payment-data");

    if (!paymentData) {
        console.error("Payment data element not found!");
        return;
    }

    // Extract data from data attributes
    const selectedSeats = JSON.parse(paymentData.dataset.selectedSeats || '[]');
    const totalPrice = parseFloat(paymentData.dataset.totalPrice || '0');
    const scheduleId = paymentData.dataset.scheduleId;

    // DOM elements
    const seatsElement = document.getElementById('selected-seats');
    const totalPriceElement = document.getElementById('total-price');
    const paymentMethods = document.querySelectorAll('.payment-method');
    const confirmPaymentBtn = document.getElementById('confirm-payment-btn');

    // Validate essential elements
    if (!seatsElement || !totalPriceElement || !confirmPaymentBtn || paymentMethods.length === 0) {
        console.error("One or more required elements are missing from the DOM.");
        return;
    }

    let selectedPaymentMethod = null;

    // Display selected seats and total price
    seatsElement.textContent = selectedSeats.length > 0
        ? selectedSeats.map(seat => `Row ${seat.row}, Seat ${seat.seat}`).join(' | ')
        : 'No seats selected.';
    totalPriceElement.textContent = `$${totalPrice.toFixed(2)}`;

    // Disable the confirm button initially
    confirmPaymentBtn.disabled = true;

    // Handle payment method selection
    paymentMethods.forEach(method => {
        method.addEventListener('click', () => {
            // Remove "selected" class from all methods
            paymentMethods.forEach(m => m.classList.remove('selected'));

            // Add "selected" class to the clicked method
            method.classList.add('selected');

            // Store the selected method
            selectedPaymentMethod = method.dataset.method;

            // Enable the confirm button if a payment method is selected
            confirmPaymentBtn.disabled = false;

            console.log("Selected Payment Method:", selectedPaymentMethod);
        });
    });

    // Handle payment confirmation
    confirmPaymentBtn.addEventListener('click', () => {
        if (!selectedPaymentMethod) {
            alert("Please select a payment method.");
            return;
        }

        console.log("Initiating booking confirmation...");

        fetch('/api/confirm-booking', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({
                selected_seats: selectedSeats,
                schedule_id: scheduleId,
                total_price: totalPrice,
                payment_method: selectedPaymentMethod,
            }),
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    window.location.href = '/bookings/success'; // Redirect to success page
                } else {
                    console.error("Booking confirmation failed:", data.message);
                    alert(data.message || "Booking confirmation failed. Please try again.");
                }
            })
            .catch(error => {
                console.error("Error confirming booking:", error);
                alert("Sorry, something went wrong while processing your payment. Please try again later.");
            });
    });
});
