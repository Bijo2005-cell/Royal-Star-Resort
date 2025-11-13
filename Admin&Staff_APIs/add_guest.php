<?php
session_start();
require '../Database/db_connect.php';

header('Content-Type: application/json');

// Security check
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['staff', 'admin'])) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Access Denied']);
    exit;
}

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'fetch_guests':
        fetch_guests($conn);
        break;
    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        break;
}

function fetch_guests($conn) {
    // THE FIX IS HERE: We've added "WHERE u.role = 'guest'" to the query.
    // This tells the database to only return records for users who are guests.
    $sql = "SELECT 
                bd.bd_id as id,
                u.username as guest_name,
                u.email as guest_email,
                u.mobile_number as guest_phone,
                bd.check_in,
                bd.check_out,
                acc.number as room_name,
                acc.acc_id as room_id
            FROM booking_details bd
            JOIN bookings b ON bd.booking_id = b.booking_id
            JOIN users u ON b.user_id = u.user_id
            JOIN accommodations acc ON bd.acc_id = acc.acc_id
            WHERE u.role = 'guest'
            ORDER BY bd.check_in DESC";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo json_encode(['status' => 'error', 'message' => 'SQL prepare failed: ' . $conn->error]);
        exit;
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $guests = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($guests);
    $stmt->close();
}

$conn->close();
?>