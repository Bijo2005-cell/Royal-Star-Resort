<?php
session_start();
require '../Database/db_connect.php'; // Use the same db_connect.php from before

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email = ? AND role = 'admin'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        // **IMPORTANT**: Verify hashed password. Store passwords using password_hash()
        if (password_verify($password, $user['password'])) {
            // Password is correct, start session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            header("Location: ../Admin&Staff_Panel/admin.php"); // Redirect to dashboard
            exit();
        }
    }
    // If login fails
    header("Location: ../Guest&Public_Pages/login.php?error=1");
    exit();
}
?>