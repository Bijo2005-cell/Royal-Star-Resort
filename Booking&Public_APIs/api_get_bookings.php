<?php
// api_get_bookings.php

header('Content-Type: application/json'); // Set the content type to JSON
session_start();

// --- RE-ENABLED SESSION CHECK ---
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(['error' => 'User not authenticated.']);
    exit;
}
// --- END RE-ENABLE ---

require_once '../Database/db_connect.php';

// --- USE SESSION ID ---
$userId = $_SESSION['user_id']; // Get ID from session
// --- END UPDATE ---

$sql = "SELECT
            b.booking_id, b.total_rate, b.booking_date, b.status, b.refund_amount,
            bd.check_in, bd.check_out,
            acc.number AS room_name, acc.image AS room_image, acc.description AS room_description,
            prog.title AS program_title, prog.description AS program_description, prog.image as program_image
        FROM bookings b
        LEFT JOIN booking_details bd ON b.booking_id = bd.booking_id
        LEFT JOIN accommodations acc ON bd.acc_id = acc.acc_id
        LEFT JOIN programs prog ON bd.program_id = prog.program_id
        WHERE b.user_id = ?
        ORDER BY b.booking_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();

// --- THIS LINE IS NOW FIXED ---
$result = $stmt->get_result(); 
// --- END FIX ---

$bookings = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
}

echo json_encode($bookings);

$stmt->close();
$conn->close();
?>