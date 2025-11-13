<?php
session_start();
require '../Database/db_connect.php';

header('Content-Type: application/json');

// Security check: Only admins can access this API
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Access Denied.']);
    exit;
}

$action = $_REQUEST['action'] ?? '';

switch ($action) {
    case 'fetch_all_leaves':
        fetchAllLeaves($conn);
        break;
    case 'update_status':
        updateStatus($conn);
        break;
    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action specified.']);
        break;
}

function fetchAllLeaves($conn) {
    // FIX: This query uses the correct column names from your database.
    $sql = "SELECT 
                lr.id, 
                u.username, 
                u.department,
                lr.leave_type, 
                lr.start_date, 
                lr.end_date, 
                lr.reason, 
                lr.status
            FROM leave_requests lr
            JOIN users u ON lr.user_id = u.id
            ORDER BY lr.start_date DESC";
            
    $result = $conn->query($sql);
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
}

function updateStatus($conn) {
    $data = json_decode(file_get_contents('php://input'), true);
    $request_id = $data['id'] ?? 0;
    $new_status = $data['status'] ?? '';

    if (empty($request_id) || !in_array($new_status, ['Approved', 'Rejected'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid input.']);
        exit;
    }

    $stmt = $conn->prepare("UPDATE leave_requests SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $request_id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
    }
}
?>