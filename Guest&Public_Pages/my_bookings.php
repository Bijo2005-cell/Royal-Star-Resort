<?php
// my_bookings.php (AJAX Version)
session_start();

// // We still need this PHP block to protect the page itself
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit;
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Bookings | Royal Star Resort</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root { --primary-color: #8B4513; --accent-color: #A0522D; }
        body { background-color: #f8f9fa; font-family: 'Poppins', sans-serif; }
        h1, h2, h3, h4, h5 { font-family: 'Playfair Display', serif; color: var(--primary-color); }
        .booking-card { margin-bottom: 2rem; }
        .placeholder-glow .placeholder { min-height: 250px; }
    </style>
</head>
<body>
    <div class="container my-5">
        <div id="message-container"></div>

        <div class="text-center mb-5">
            <h1>My Bookings</h1>
            <p class="lead text-muted">A summary of your reservations with Royal Star Resort.</p>
        </div>

        <div id="bookings-container">
            <div class="card booking-card shadow-sm placeholder-glow">
                <div class="card-body"><div class="placeholder col-12"></div></div>
            </div>
            <div class="card booking-card shadow-sm placeholder-glow">
                <div class="card-body"><div class="placeholder col-12"></div></div>
            </div>
        </div>
    </div>

    <script>
        // Wait for the document to be fully loaded before running scripts
        document.addEventListener('DOMContentLoaded', function() {
            
            // Function to display messages from PHP session (e.g., after cancellation)
            const displayFlashMessage = () => {
                <?php if (isset($_SESSION['message'])): ?>
                const messageContainer = document.getElementById('message-container');
                const message = <?php echo json_encode($_SESSION['message']); ?>;
                messageContainer.innerHTML = `
                    <div class="alert alert-${message.type} alert-dismissible fade show" role="alert">
                        ${message.text}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                <?php unset($_SESSION['message']); ?>
                <?php endif; ?>
            };
            
            // Function to format dates
            const formatDate = (dateString) => {
                if (!dateString) return '';
                const options = { year: 'numeric', month: 'short', day: 'numeric' };
                return new Date(dateString).toLocaleDateString('en-US', options);
            };

            // Main function to fetch and display bookings
            const fetchBookings = async () => {
                const container = document.getElementById('bookings-container');
                
                try {
                    const response = await fetch('../Booking&Public_APIs/api_get_bookings.php');
                    if (!response.ok) {
                        // If the API returns a 401 or similar error, it will be caught here.
                        const errorData = await response.json().catch(() => ({ error: 'Failed to parse error response' }));
                        throw new Error(`Network response was not ok. Server says: ${errorData.error || response.statusText}`);
                    }
                    const bookings = await response.json();

                    // Clear the loading placeholders
                    container.innerHTML = '';

                    if (bookings.length === 0) {
                        // Display the "No Bookings Found" message
                        container.innerHTML = `
                        <div class="text-center">
                            <div class="alert alert-info col-md-6 mx-auto">
                                <h4 class="alert-heading">No Bookings Found!</h4>
                                <p>You have not made any reservations yet. Explore our accommodations to plan your stay.</p>
                                <hr>
                                <a href="../Guest&Public_Pages/room.php" class="btn btn-primary">View Rooms & Villas</a>
                            </div>
                        </div>`;
                    } else {
                        // Loop through each booking and create an HTML card for it
                        bookings.forEach(booking => {
                            const checkInDate = new Date(booking.check_in);
                            // Cancellation is allowed if status is 'Confirmed' and check-in date is in the future.
                            const isCancellable = booking.status === 'Confirmed' && checkInDate > new Date();
                            
                            let actionButtonHTML = '';
                            if (isCancellable) {
                                actionButtonHTML = `
                                <p class="small text-muted mb-2">Eligible for cancellation (70% refund).</p>
                                <div class="d-grid">
                                    <a href="../Guest&Public_Pages/cancel_booking.php?id=${booking.booking_id}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to cancel?');">
                                        <i class="fas fa-times-circle me-1"></i>Cancel Booking
                                    </a>
                                </div>`;
                            } else if (booking.status === 'Cancelled') {
                                const refund = parseFloat(booking.refund_amount).toLocaleString('en-IN', { style: 'currency', currency: 'INR' });
                                actionButtonHTML = `<div class="alert alert-warning p-2 small text-center">Cancelled<br>Refund: ${refund}</div>`;
                            } else {
                                actionButtonHTML = `<div class="alert alert-secondary p-2 small text-center">Not Eligible for Cancellation</div>`;
                            }

                            const roomHTML = booking.room_name ? `
                                <div class="d-flex mb-4">
                                    <img src="${booking.room_image}" class="img-fluid rounded me-4" style="width: 150px; height: 100px; object-fit: cover;" alt="Room">
                                    <div><h4>${booking.room_name}</h4><p class="text-muted small">${booking.room_description}</p></div>
                                </div>` : '';
                            
                            const programHTML = booking.program_title ? `
                                <div class="d-flex">
                                    <img src="${booking.program_image}" class="img-fluid rounded me-4" style="width: 150px; height: 100px; object-fit: cover;" alt="Program">
                                    <div><h4>${booking.program_title}</h4><p class="text-muted small">${booking.program_description}</p></div>
                                </div>` : '';

                            const card = document.createElement('div');
                            card.className = 'card booking-card shadow-sm';
                            card.innerHTML = `
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Booking #${booking.booking_id}</h5>
                                    <span class="badge bg-${booking.status === 'Confirmed' ? 'success' : 'warning'}">${booking.status}</span>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-8">${roomHTML}${programHTML}</div>
                                        <div class="col-lg-4 border-start">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex justify-content-between"><span>Booked On:</span><strong>${formatDate(booking.booking_date)}</strong></li>
                                                ${booking.check_in ? `<li class="list-group-item d-flex justify-content-between"><span>Check-in:</span><strong>${formatDate(booking.check_in)}</strong></li>` : ''}
                                                <li class="list-group-item d-flex justify-content-between mt-2 pt-2 border-top">
                                                    <span class="h5 mb-0">Total:</span><strong class="h5 mb-0" style="color: var(--accent-color);">${parseFloat(booking.total_rate).toLocaleString('en-IN', { style: 'currency', currency: 'INR' })}</strong>
                                                </li>
                                            </ul>
                                            <div class="mt-3">${actionButtonHTML}</div>
                                        </div>
                                    </div>
                                </div>`;
                            container.appendChild(card);
                        });
                    }
                } catch (error) {
                    console.error('Fetch error:', error);
                    container.innerHTML = `<div class="alert alert-danger">Could not load bookings. Please try again later.</div>`;
                }
            };
            
            // Initial call to load everything
            displayFlashMessage();
            fetchBookings();
        });
    </script>
</body>
</html>