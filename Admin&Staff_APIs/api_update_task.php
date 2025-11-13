<?php
session_start();
include '../Database/db_connect.php';

header('Content-Type: application/json');

// Security check: Only staff can update tasks
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    echo json_encode(['error' => 'Access Denied']);
    exit();
}

// Get data from JSON payload
$data = json_decode(file_get_contents('php://input'), true);

if ($data && isset($data['task_id']) && isset($data['status'])) {
    $task_id = $data['task_id'];
    $status = $data['status'] ? 'Completed' : 'Pending';
    $user_id = $_SESSION['user_id']; // The logged-in staff member

    // Update the task status
    // CRITICAL: We also check user_id to ensure staff can only update THEIR OWN tasks
    // --- FIX APPLIED HERE ---
    $stmt = $conn->prepare("UPDATE tasks SET status = ? WHERE task_id = ? AND assigned_to_user_id = ?");
    $stmt->bind_param("sii", $status, $task_id, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Log this action
        $log_title = "Task " . $status;
        $log_desc = "Task ID " . $task_id . " marked as " . $status;
        $log_stmt = $conn->prepare("INSERT INTO activity_log (user_id, action_title, action_description) VALUES (?, ?, ?)");
        $log_stmt->bind_param("iss", $user_id, $log_title, $log_desc);
        $log_stmt->execute();
        
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Task not found or permission denied']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['error' => 'Invalid input']);
}
?>