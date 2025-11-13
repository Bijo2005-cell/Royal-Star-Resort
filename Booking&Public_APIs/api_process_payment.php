<?php
// api_process_payment.php
session_start(); // Added
header('Content-Type: application/json');

function send_json_error($message) {
    echo json_encode(['status' => 'error', 'message' => $message]);
    exit();
}

// Get the data sent from the payment page
$json_data = file_get_contents('php://input');
$data = json_decode($json_data);

if (!$data || !isset($data->bookingId) || !isset($data->amount)) {
    send_json_error('Invalid payment data received.');
}

require_once '../Database/db_connect.php';
if ($conn->connect_error) {
    send_json_error('Database connection failed.');
}

$booking_id = $data->bookingId;
$amount = $data->amount;

// --- UPDATED USER ID LOGIC ---
if (!isset($_SESSION['user_id'])) {
    send_json_error('User is not logged in.');
}
$user_id = $_SESSION['user_id']; // Use session ID
// --- END UPDATE ---

try {
    // Use a prepared statement to securely insert the payment data
    $stmt = $conn->prepare("INSERT INTO payment (booking_id, user_id, amount, payment_date) VALUES (?, ?, ?, NOW())");
    if (!$stmt) {
        throw new Exception("SQL prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("iid", $booking_id, $user_id, $amount);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        throw new Exception("Failed to record the payment in the database.");
    }
    
    // You could also update the status of the booking here if you have a 'status' column
    // For example: "UPDATE bookings SET status = 'confirmed' WHERE booking_id = ?"

    echo json_encode(['status' => 'success', 'message' => 'Payment recorded successfully.']);
    
} catch (Exception $e) {
    send_json_error("Database error: " . $e->getMessage());
}

$stmt->close();
$conn->close();
?>