<?php
session_start();
require '../Database/db_connect.php';

// Security: Only authenticated staff or admins can perform this action
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['staff', 'admin'])) {
    http_response_code(403); // Forbidden
    echo json_encode(['success' => false, 'message' => 'Access Denied']);
    exit;
}

header('Content-Type: application/json');

// Ensure the request is a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // --- Data Validation ---
    if (empty($_POST['id']) || empty($_POST['guest_name']) || empty($_POST['check_in']) || empty($_POST['check_out'])) {
        echo json_encode(['success' => false, 'message' => 'Required fields (ID, Name, Check-in/Out) are missing.']);
        exit;
    }

    // --- SQL UPDATE Statement ---
    $sql = "UPDATE booking SET 
                guest_name = ?, 
                guest_email = ?, 
                guest_phone = ?, 
                room_id = ?, 
                adults = ?, 
                check_in = ?, 
                check_out = ?, 
                special_requests = ? 
            WHERE id = ?";

    $stmt = $conn->prepare($sql);

    // Check if the statement was prepared successfully
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        exit;
    }

    // Bind parameters to the prepared statement to prevent SQL injection
    $stmt->bind_param("sssiisssi", 
        $_POST['guest_name'], 
        $_POST['guest_email'], 
        $_POST['guest_phone'],
        $_POST['room_id'],
        $_POST['adults'],
        $_POST['check_in'],
        $_POST['check_out'],
        $_POST['special_requests'],
        $_POST['id'] // The ID for the WHERE clause
    );

    // Execute the statement and send back a response
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Guest record updated successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update guest record: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    // Handle cases where the script is accessed directly without a POST request
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
