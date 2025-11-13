<?php
session_start();
require '../Database/db_connect.php';

// Security Check
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Access Denied']);
    exit;
}

header('Content-Type: application/json');

$user_id = $_SESSION['user_id'];

// This query correctly selects the 'status' column.
$stmt = $conn->prepare(
    "SELECT id, leave_type, start_date, end_date, status 
     FROM leave_requests 
     WHERE user_id = ? 
     ORDER BY start_date DESC"
);

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$leave_history = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($leave_history);

$stmt->close();
$conn->close();
?>