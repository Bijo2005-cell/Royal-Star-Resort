<?php
// process_booking.php

header('Content-Type: application/json');
require_once '../Database/db_connect.php';

$response = array('status' => 'error', 'message' => 'An unknown error occurred.');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $roomId = filter_input(INPUT_POST, 'roomId', FILTER_VALIDATE_INT);
    $checkIn = $_POST['checkIn'] ?? '';
    $checkOut = $_POST['checkOut'] ?? '';
    $adults = filter_input(INPUT_POST, 'adults', FILTER_VALIDATE_INT);
    $children = filter_input(INPUT_POST, 'children', FILTER_VALIDATE_INT);

    // Basic validation
    if ($roomId && $checkIn && $checkOut && $adults) {
        try {
            // Use prepared statements to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO bookings (room_id, check_in_date, check_out_date, num_adults, num_children) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issii", $roomId, $checkIn, $checkOut, $adults, $children);
            
            if ($stmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = 'Thank you for your reservation request! We will contact you shortly to confirm your booking.';
            } else {
                $response['message'] = 'Database error: Could not save the booking.';
            }
            $stmt->close();
        } catch (Exception $e) {
            $response['message'] = 'An exception occurred: ' . $e->getMessage();
        }
    } else {
        $response['message'] = 'Invalid form data. Please fill all required fields.';
    }
} else {
    $response['message'] = 'Invalid request method.';
}

$conn->close();
echo json_encode($response);
?>