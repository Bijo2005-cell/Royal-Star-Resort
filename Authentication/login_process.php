<?php
// Start session
session_start();

// Include database connection
require_once '../Database/db_connect.php';

// Set JSON header for responses
header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

// Get form data (using 'user' and 'pass' from your login.php form)
$usernameOrEmail = trim($_POST['user'] ?? '');
$password = trim($_POST['pass'] ?? '');

if (empty($usernameOrEmail) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'Username/Email and password are required.']);
    exit;
}

// Prepare SQL to prevent SQL injection
// CORRECTED: Queries 'users' table and selects 'id' instead of 'user_id'
$sql = "SELECT id, username, password, role FROM users WHERE (username = ? OR email = ?) LIMIT 1";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    error_log("MySQL prepare error: " . $conn->error);
    echo json_encode(['status' => 'error', 'message' => 'Internal server error.']);
    exit;
}

$stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Verify the hashed password
    if (password_verify($password, $user['password'])) {
        // Password is correct, set session variables
        // CORRECTED: Uses 'id' from the database result
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role']; // Store the role in the session

        // *** ROLE-BASED REDIRECT LOGIC ***
        $redirect_url = '../Guest&Public_Pages/login.php'; // Default redirect
        switch ($user['role']) {
            case 'admin':
                $redirect_url = '../Admin&Staff_Panel/admin.php';
                break;
            case 'staff':
                $redirect_url = '../Admin&Staff_Panel/employee.php';
                break;
            case 'guest':
                $redirect_url = '../Guest&Public_Pages/guest.php';
                break;
        }

        echo json_encode([
            'status' => 'success',
            'message' => 'Login successful! Redirecting...',
            'redirect' => $redirect_url
        ]);

    } else {
        // Incorrect password
        echo json_encode(['status' => 'error', 'message' => 'Invalid username or password.']);
    }
} else {
    // User not found
    echo json_encode(['status' => 'error', 'message' => 'Invalid username or password.']);
}

$stmt->close();
$conn->close();
?>