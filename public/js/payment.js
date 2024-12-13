document.addEventListener("DOMContentLoaded", () => {
    // Retrieve data from the payment container
    const paymentContainer = document.getElementById('payment-container');
    const confirmPaymentBtn = document.getElementById('confirm-payment-btn');
    const seatsElement = document.getElementById('selected-seats');
    const totalPriceElement = document.getElementById('total-price');

    // Initialize payment variables
    let selectedSeats = [];
    let totalPrice = 0;
    let selectedMethod = null;

    // Parse data attributes
    try {
        selectedSeats = JSON.parse(paymentContainer.dataset.selectedSeats || '[]');
        totalPrice = parseFloat(paymentContainer.dataset.totalPrice || '0');
    } catch (error) {
        console.error("Error parsing selectedSeats or totalPrice:", error);
    }

    // Populate booking summary
    const formattedSeats = Array.isArray(selectedSeats) && selectedSeats.length
        ? selectedSeats.map(seat => `Row ${seat.row}, Seat ${seat.number}`).join(', ')
        : "No seats selected.";
    seatsElement.textContent = formattedSeats;
    totalPriceElement.textContent = `$${totalPrice.toFixed(2)}`;

    // Handle payment method selection
    const paymentMethods = document.querySelectorAll('.payment-method');
    paymentMethods.forEach(method => {
        method.addEventListener('click', () => {
            // Deselect all methods
            paymentMethods.forEach(m => m.classList.remove('selected'));

            // Select the clicked method
            method.classList.add('selected');
            selectedMethod = method.dataset.method;

            // Enable the confirm button
            confirmPaymentBtn.disabled = false;
        });
    });

    // Handle payment confirmation
    confirmPaymentBtn.addEventListener('click', () => {
        if (!selectedMethod) {
            console.error("Error: No payment method selected.");
            return;
        }

        console.log(`Payment method selected: ${selectedMethod}`);
        // Redirect to success page (simulate payment processing)
        window.location.href = '/bookings/success';
    });
});
