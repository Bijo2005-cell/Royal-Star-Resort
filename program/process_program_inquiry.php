<?php
// process_program_inquiry.php

header('Content-Type: application/json');
require_once '../Database/db_connect.php';

$response = ['status' => 'error', 'message' => 'An unknown error occurred.'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $programId = filter_input(INPUT_POST, 'program_id', FILTER_VALIDATE_INT);
    $parentName = trim($_POST['parentName'] ?? '');
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = trim($_POST['phone'] ?? '');
    $guestCount = filter_input(INPUT_POST, 'guestCount', FILTER_VALIDATE_INT);
    $partyDate = trim($_POST['partyDate'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Basic validation
    if ($programId && !empty($parentName) && filter_var($email, FILTER_VALIDATE_EMAIL) && $guestCount && !empty($partyDate)) {
        try {
            $stmt = $conn->prepare(
                "INSERT INTO program_inquiries (program_id, parent_name, email, phone, guest_count, preferred_date, message) VALUES (?, ?, ?, ?, ?, ?, ?)"
            );
            $stmt->bind_param("isssiss", $programId, $parentName, $email, $phone, $guestCount, $partyDate, $message);
            
            if ($stmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = 'Thank you! Your inquiry has been sent. Our event planner will contact you shortly.';
            } else {
                $response['message'] = 'Database error: Could not save your inquiry.';
            }
            $stmt->close();
        } catch (Exception $e) {
            $response['message'] = 'An error occurred: ' . $e->getMessage();
        }
    } else {
        $response['message'] = 'Invalid form data. Please fill all required fields correctly.';
    }
} else {
    $response['message'] = 'Invalid request method.';
}

$conn->close();
echo json_encode($response);
?>