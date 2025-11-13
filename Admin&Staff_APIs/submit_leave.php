<?php
session_start();
require '../Database/db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Access Denied. Please log in.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $leave_type = $_POST['leaveType'] ?? '';
    $start_date = $_POST['startDate'] ?? '';
    $end_date = $_POST['endDate'] ?? '';
    $reason = $_POST['reason'] ?? '';
    $contact_info = $_POST['contactInfo'] ?? '';
    $status = 'Pending';

    if (empty($leave_type) || empty($start_date) || empty($end_date) || empty($reason)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
        exit;
    }

    $stmt = $conn->prepare(
        "INSERT INTO leave_requests (user_id, leave_type, start_date, end_date, reason, contact_info, status) 
         VALUES (?, ?, ?, ?, ?, ?, ?)"
    );
    
    $stmt->bind_param("issssss", $user_id, $leave_type, $start_date, $end_date, $reason, $contact_info, $status);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Your leave request has been submitted successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>