<?php
session_start();
include '../Database/db_connect.php';

// Security check: Only admins can add tasks
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $priority = $_POST['priority'];
    $due_date = !empty($_POST['due_date']) ? $_POST['due_date'] : NULL;
    $admin_id = $_SESSION['user_id']; // The admin who is creating the task
    
    // Insert the new task
    // --- FIX APPLIED HERE ---
    $stmt = $conn->prepare("INSERT INTO tasks (assigned_to_user_id, assigned_by_user_id, title, description, priority, due_date) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissss", $user_id, $admin_id, $title, $description, $priority, $due_date);
    $stmt->execute();

    // Log this action
    $log_title = "New Task Assigned";
    $log_desc = "Task '" . $title . "' assigned to user ID " . $user_id;
    $log_stmt = $conn->prepare("INSERT INTO activity_log (user_id, action_title, action_description) VALUES (?, ?, ?)");
    $log_stmt->bind_param("iss", $admin_id, $log_title, $log_desc);
    $log_stmt->execute();
    
    $stmt->close();
    $log_stmt->close();
    $conn->close();

    // Redirect back to the task page
    header('Location: ../Admin&Staff_Panel/task_mang.php?success=1'); // Assumes admin_tasks.php is in the root
    exit();
}
?>