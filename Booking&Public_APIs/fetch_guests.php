<?php
session_start();
require '../Database/db_connect.php';

// Security: Only staff and admins can access
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['staff', 'admin'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Access Denied']);
    exit;
}

header('Content-Type: application/json');

// Base query with JOIN
$sql = "SELECT b.id, b.guest_name, b.guest_email, b.guest_phone, b.check_in, b.check_out, b.adults, b.special_requests, a.name as room_name 
        FROM booking b
        JOIN accommodation a ON b.room_id = a.id";

// Dynamic WHERE clause for filters (add more as needed)
// This is a simplified example. A full implementation would use prepared statements.
$conditions = [];
if (!empty($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $conditions[] = "(b.guest_name LIKE '%$search%' OR a.name LIKE '%$search%')";
}
// Add more filter conditions here...

if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

$result = $conn->query($sql);
$guests = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($guests);
$conn->close();
?>