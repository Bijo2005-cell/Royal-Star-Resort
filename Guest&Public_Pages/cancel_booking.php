<?php
// cancel_booking.php
session_start();
require_once '../Database/db_connect.php';

// --- UPDATED USER ID LOGIC ---
if (!isset($_SESSION['user_id'])) {
    redirect_with_message('danger', 'You must be logged in to manage bookings.');
}
$user_id = $_SESSION['user_id']; // Use session ID
// --- END UPDATE ---

/**
 * Helper function to set a session message and redirect.
 * @param string $type - 'success', 'danger', 'warning'
 * @param string $text - The message to display.
 */
function redirect_with_message($type, $text) {
    $_SESSION['message'] = ['type' => $type, 'text' => $text];
    header("Location: my_bookings.php");
    exit;
}

// 1. Validate input
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirect_with_message('danger', 'Invalid booking ID.');
}
$booking_id = intval($_GET['id']);

if ($conn->connect_error) {
     redirect_with_message('danger', 'Database connection failed.');
}

try {
    // 2. Fetch the booking to verify ownership and cancellability
    $sql_fetch = "SELECT b.user_id, b.status, b.total_rate, bd.check_in
                  FROM bookings b
                  JOIN booking_details bd ON b.booking_id = bd.booking_id
                  WHERE b.booking_id = ?";
    
    $stmt_fetch = $conn->prepare($sql_fetch);
    $stmt_fetch->bind_param("i", $booking_id);
    $stmt_fetch->execute();
    $result = $stmt_fetch->get_result();

    if ($result->num_rows === 0) {
        redirect_with_message('danger', 'Booking not found.');
    }

    $booking = $result->fetch_assoc();
    $stmt_fetch->close();

    // 3. --- Server-Side Verification ---

    // Check 1: Ownership
    if ($booking['user_id'] != $user_id) { // Use session ID
        redirect_with_message('danger', 'You are not authorized to cancel this booking.');
    }

    // Check 2: Status
    if ($booking['status'] !== 'Confirmed') {
        redirect_with_message('warning', 'This booking cannot be cancelled (Status: ' . htmlspecialchars($booking['status']) . ').');
    }

    // Check 3: Date
    $check_in_date = new DateTime($booking['check_in']);
    $today = new DateTime(); 

    if ($check_in_date <= $today) {
        redirect_with_message('warning', 'This booking cannot be cancelled as its check-in date has passed.');
    }

    // 4. --- Process the Cancellation ---
    
    $refund_amount = (float)$booking['total_rate'] * 0.70;

    $sql_update = "UPDATE bookings 
                   SET status = 'Cancelled', refund_amount = ?
                   WHERE booking_id = ?";
                   
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("di", $refund_amount, $booking_id);
    
    if ($stmt_update->execute()) {
        $refund_formatted = '₹' . number_format($refund_amount, 2);
        redirect_with_message('success', "Booking #$booking_id has been cancelled. A refund of $refund_formatted (70%) will be processed.");
    } else {
        redirect_with_message('danger', 'Failed to update booking status in the database.');
    }
    
    $stmt_update->close();
    
} catch (Exception $e) {
    redirect_with_message('danger', 'An error occurred: ' . $e->getMessage());
} finally {
    $conn->close();
}
?>