<?php
session_start();
require '../Database/db_connect.php';

// Security: Only admins can perform this action
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Access Denied']);
    exit;
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the raw POST data
    $json_data = file_get_contents('php://input');
    // Decode the JSON data
    $data = json_decode($json_data, true);

    if (empty($data['id']) || empty($data['status'])) {
        echo json_encode(['success' => false, 'message' => 'Request ID and status are required.']);
        exit;
    }

    $request_id = $data['id'];
    $new_status = $data['status']; // Should be 'Approved' or 'Rejected'

    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("UPDATE leave_requests SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $request_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => "Leave request has been {$new_status}."]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update status: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
