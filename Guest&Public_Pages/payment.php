<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #8B4513; --secondary-color: #D4AF37; --dark-color: #333333;
            --light-color: #f8f9fa; --accent-color: #A0522D;
        }
        body { background-color: var(--light-color); color: var(--dark-color); font-family: 'Poppins', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Playfair Display', serif; color: var(--primary-color); }
        .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); font-weight: 500; padding: 0.75rem 1.25rem; }
        .btn-primary:hover, .btn-primary:focus { background-color: var(--accent-color); border-color: var(--accent-color); }
        .section-header { border-bottom: 2px solid var(--accent-color); padding-bottom: 0.5rem; margin-bottom: 1.5rem; }
        .card { border: 1px solid var(--accent-color); }
        .form-control:focus, .form-select:focus { border-color: var(--secondary-color); box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.5); }
        .total { font-size: 1.75rem; font-weight: bold; color: var(--primary-color); }
        .summary-card { background-color: #fff; border: 1px solid var(--accent-color); }
        .nav-pills .nav-link { color: var(--primary-color); }
        .nav-pills .nav-link.active { background-color: var(--primary-color); color: white; }
        .loader { border: 5px solid #f3f3f3; border-radius: 50%; border-top: 5px solid var(--primary-color); width: 40px; height: 40px; animation: spin 1s linear infinite; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        .d-none { display: none; }
    </style>
</head>
<body>

    <div class="container my-5">
        <div class="text-center mb-5">
            <h1>Complete Your Payment</h1>
            <p class="lead text-muted">Please select a payment method to finalize your booking.</p>
        </div>
 
        <div class="row g-5">
            <div class="col-lg-7">
                <div class="card p-4">
                    <div id="payment-interface">
                        <h3 class="section-header">Payment Method</h3>
                        <ul class="nav nav-pills mb-4" id="payment-methods-tab" role="tablist">
                            <li class="nav-item" role="presentation"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#card-pane" type="button">Credit/Debit Card</button></li>
                            <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#upi-pane" type="button">UPI</button></li>
                            <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#netbanking-pane" type="button">Net Banking</button></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="card-pane">
                                <form id="card-form">
                                    <div class="mb-3"><label for="cardName" class="form-label">Name on Card</label><input type="text" class="form-control" id="cardName" placeholder="" required></div>
                                    <div class="mb-3"><label for="cardNumber" class="form-label">Card Number</label><input type="text" class="form-control" id="cardNumber" placeholder="xxxx xxxx xxxx xxxx" required></div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3"><label for="cardExpiry" class="form-label">Expiry Date</label><input type="text" class="form-control" id="cardExpiry" placeholder="MM / YY" required></div>
                                        <div class="col-md-6 mb-3"><label for="cardCvv" class="form-label">CVV</label><input type="text" class="form-control" id="cardCvv" placeholder="123" required></div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="upi-pane">
                                <div class="text-center"><img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=upi://pay?pa=royalstar@okhdfcbank" alt="UPI QR Code" class="img-fluid mb-3"><p>Scan the QR code with your UPI app</p><hr><p class="text-muted">Or enter your UPI ID</p><div class="input-group mb-3"><input type="text" class="form-control" placeholder="yourname@upi"><button class="btn btn-outline-secondary" type="button">Verify</button></div></div>
                            </div>
                            <div class="tab-pane fade" id="netbanking-pane">
                                <p>You will be redirected to your bank's secure portal to complete the payment.</p>
                                <select class="form-select"><option selected>Choose your bank...</option><option value="1">HDFC Bank</option><option value="2">ICICI Bank</option><option value="3">State Bank of India</option><option value="4">Axis Bank</option></select>
                            </div>
                        </div>
                    </div>
                    <div id="payment-success-message" class="d-none text-center py-5"></div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card summary-card p-4 position-sticky" style="top: 2rem;">
                    <h3 class="section-header">Booking Summary</h3>
                    <div id="summary-loader" class="d-flex justify-content-center my-3"><div class="loader"></div></div>
                    <div id="summary-content" class="d-none">
                        <div class="d-flex justify-content-between mb-2"><span class="text-muted">Room</span><span id="summary-room-name"></span></div>
                        <div class="d-flex justify-content-between mb-2"><span class="text-muted">Check-in</span><span id="summary-checkin"></span></div>
                        <div class="d-flex justify-content-between mb-3"><span class="text-muted">Check-out</span><span id="summary-checkout"></span></div>
                        <hr style="border-color: var(--accent-color);">
                        <div id="price-breakdown"></div>
                        <hr style="border-color: var(--accent-color);">
                        <div class="d-flex justify-content-between align-items-center"><h5>Amount Payable</h5><div class="total" id="total-price">₹0.00</div></div>
                        <div id="download-bill-container" class="text-center mt-3"></div>
                    </div>
                    <div class="d-grid mt-4">
                         <button type="button" class="btn btn-primary btn-lg" id="pay-now-btn" disabled>Pay Now</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const summaryLoader = document.getElementById('summary-loader');
            const summaryContent = document.getElementById('summary-content');
            const payNowBtn = document.getElementById('pay-now-btn');
            const totalPriceEl = document.getElementById('total-price');
            const breakdownContainer = document.getElementById('price-breakdown');
            const downloadContainer = document.getElementById('download-bill-container');
            const paymentInterface = document.getElementById('payment-interface');
            const successMessageDiv = document.getElementById('payment-success-message');

            const urlParams = new URLSearchParams(window.location.search);
            const bookingId = urlParams.get('id');

            if (!bookingId) {
                summaryContent.innerHTML = '<div class="alert alert-danger">Invalid booking ID.</div>';
                summaryLoader.classList.add('d-none');
                summaryContent.classList.remove('d-none');
            } else {
                fetchBookingDetails();
            }

            // --- NEW HELPER FUNCTION ---
            // Safely formats a date string, returning 'N/A' if the date is invalid or null
            function formatDate(dateString) {
                if (!dateString || dateString === '0000-00-00') {
                    return 'N/A';
                }
                try {
                    const date = new Date(dateString);
                    // Check if date is valid
                    if (isNaN(date.getTime())) {
                        return 'N/A';
                    }
                    return date.toLocaleDateString('en-GB', { day: 'numeric', month: 'long', year: 'numeric' });
                } catch (e) {
                    return 'N/A';
                }
            }

            async function fetchBookingDetails() {
                try {
                    const response = await fetch(`../Booking&Public_APIs/api_get_booking_details.php?id=${bookingId}`);
                    if (!response.ok) throw new Error('Network response was not ok. Please check the API file path and for PHP errors.');
                    
                    const data = await response.json();
                    if (data.status === 'error') throw new Error(data.message);

                    // --- MODIFIED SECTION ---
                    // Use the safe formatDate function to prevent script-crashing errors
                    document.getElementById('summary-room-name').textContent = data.details.room_name || 'Booking';
                    document.getElementById('summary-checkin').textContent = formatDate(data.details.check_in);
                    document.getElementById('summary-checkout').textContent = formatDate(data.details.check_out);
                    // --- END MODIFIED SECTION ---
                    
                    let breakdownHtml = '';
                    data.breakdown.forEach(item => {
                        const amountClass = item.is_discount ? 'text-success' : 'text-muted';
                        const sign = item.amount < 0 ? '-' : '';
                        
                        breakdownHtml += `
                            <div class="d-flex justify-content-between mb-1 small">
                                <span class="${amountClass}">${item.description}</span>
                                <span class="${amountClass}">${sign} ₹${Math.abs(item.amount).toFixed(2)}</span>
                            </div>
                        `;
                    });
                    breakdownContainer.innerHTML = breakdownHtml;
                    
                    totalPriceEl.textContent = `₹${parseFloat(data.details.total_rate).toFixed(2)}`;
                    
                    downloadContainer.innerHTML = `<a href="../Guest&Public_Pages/invoice.php?id=${bookingId}" target="_blank" class="btn btn-sm btn-outline-secondary">Download Pro-forma Invoice</a>`;
                    
                    summaryLoader.classList.add('d-none');
                    summaryContent.classList.remove('d-none');
                    payNowBtn.disabled = false;

                } catch (error) {
                    console.error('Fetch error:', error);
                    summaryContent.innerHTML = `<div class="alert alert-danger">Error: ${error.message}</div>`;
                    summaryLoader.classList.add('d-none');
                    summaryContent.classList.remove('d-none');
                }
            }

            payNowBtn.addEventListener('click', async () => {
                payNowBtn.disabled = true;
                payNowBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Processing...';
                
                const totalAmountText = totalPriceEl.textContent.replace('₹', '').replace(/,/g, '');
                const totalAmount = parseFloat(totalAmountText);

                try {
                    const response = await fetch('../Booking&Public_APIs/api_process_payment.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            bookingId: bookingId,
                            amount: totalAmount
                        })
                    });

                    const result = await response.json();

                    if (result.status !== 'success') {
                        throw new Error(result.message || 'Payment processing failed. Please try again.');
                    }

                    paymentInterface.classList.add('d-none');
                    
                    successMessageDiv.innerHTML = `
                        <div style="font-size: 4rem; color: #28a745;">&#10003;</div>
                        <h3 class="mt-3">Payment Successful!</h3>
                        <p class="lead">The amount of <strong>₹${totalAmount.toFixed(2)}</strong> has been successfully paid.</p>
                        <p class="text-muted">You will be redirected shortly...</p>
                    `;
                    successMessageDiv.classList.remove('d-none');
                    payNowBtn.classList.add('d-none');

                  

                } catch (error) {
                    alert('Error: ' + error.message);
                    payNowBtn.disabled = false;
                    payNowBtn.innerHTML = 'Pay Now';
                }
            });
        });
    </script>
</body>
</html>