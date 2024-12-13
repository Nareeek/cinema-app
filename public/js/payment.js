document.addEventListener("DOMContentLoaded", () => {
    const paymentContainer = document.getElementById('payment-container');

    // Parse data from the container
    const selectedSeats = JSON.parse(paymentContainer.dataset.selectedSeats || '[]');
    const totalPrice = parseFloat(paymentContainer.dataset.totalPrice || '0');
    const scheduleId = paymentContainer.dataset.scheduleId;

    // Function to format seats
    function formatSeats(seats) {
        // Group seats by row
        const groupedByRow = seats.reduce((acc, seat) => {
            const row = seat.row_number; // Use correct property name
            const number = seat.seat_number; // Use correct property name

            if (row && number) { // Ensure both row and number exist
                acc[row] = acc[row] || [];
                acc[row].push(number);
            }
            return acc;
        }, {});

        // Format grouped data into a readable string
        return Object.entries(groupedByRow)
            .map(([row, numbers]) => `Row ${row}: Seats ${numbers.join(', ')}`)
            .join(' | ');
    }

    // Populate booking summary
    const seatsElement = document.getElementById('selected-seats');
    const totalPriceElement = document.getElementById('total-price');

    // Format and display selected seats
    seatsElement.textContent = selectedSeats.length > 0
        ? formatSeats(selectedSeats)
        : 'No seats selected.';

    // Display total price
    totalPriceElement.textContent = `$${totalPrice.toFixed(2)}`; // Add dollar sign

    // Payment Methods Logic
    const paymentMethods = document.querySelectorAll('.payment-method');
    const confirmPaymentBtn = document.getElementById('confirm-payment-btn');
    let selectedMethod = null;

    // Handle payment method selection
    paymentMethods.forEach(method => {
        method.addEventListener('click', () => {
            paymentMethods.forEach(m => m.classList.remove('selected')); // Deselect all methods
            method.classList.add('selected'); // Highlight the selected method
            selectedMethod = method.dataset.method; // Set selected method
            confirmPaymentBtn.disabled = false; // Enable confirm button
        });
    });

    // Handle payment confirmation
    confirmPaymentBtn.addEventListener('click', () => {
        if (!selectedMethod) return; // Ensure a payment method is selected

        // Confirm booking via API
        fetch('/api/confirm-booking', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({
                selected_seats: selectedSeats,
                schedule_id: scheduleId,
                payment_method: selectedMethod,
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
                    alert("Booking confirmation failed. Please try again.");
                }
            })
            .catch(error => {
                console.error("Error confirming booking:", error);
                alert("An error occurred. Please try again.");
            });
    });
});
