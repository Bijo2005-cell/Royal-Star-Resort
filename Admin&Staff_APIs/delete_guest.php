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
    if (empty($_POST['id'])) {
        echo json_encode(['success' => false, 'message' => 'Guest ID is missing.']);
        exit;
    }
    
    $guest_id = $_POST['id'];

    // --- SQL DELETE Statement ---
    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM booking WHERE id = ?");
    
    // Check if the statement was prepared successfully
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        exit;
    }

    // Bind the ID parameter
    $stmt->bind_param("i", $guest_id);

    // Execute the statement and send back a response
    if ($stmt->execute()) {
        // Check if any row was actually deleted
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Guest record deleted successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No guest found with that ID.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete guest record: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    // Handle cases where the script is accessed directly without a POST request
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
