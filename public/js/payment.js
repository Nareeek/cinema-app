// Mock Data: Replace with actual booking details
const selectedSeats = ['R1-S1', 'R1-S2'];
const totalPrice = 20.00;

// Populate booking summary
document.getElementById('selected-seats').textContent = selectedSeats.join(', ');
document.getElementById('total-price').textContent = totalPrice.toFixed(2);

// Handle Payment Submission
document.getElementById('payment-form').addEventListener('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    const paymentMethod = formData.get('payment_method');

    // Simulate payment processing
    alert(`Payment successful using ${paymentMethod}!`);
    window.location.href = '/bookings/success'; // Redirect to success page
});
