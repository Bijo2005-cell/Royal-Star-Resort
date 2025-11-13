<?php

// Set the content type to JSON and prevent direct error display
header('Content-Type: application/json');
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Use the robust db_connect.php you created earlier
require '../Database/db_connect.php';

// --- 1. Check for POST Request ---
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

// --- 2. Collect and Validate Form Data ---
// The keys here MUST match the 'name' attributes in your register.php form
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['conpass'] ?? ''; // From name="conpass"
$mobile = $_POST['mobileNumber'] ?? '';   // From name="mobileNumber"

if (empty($name) || empty($email) || empty($username) || empty($password) || empty($mobile)) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
    exit;
}
if ($password !== $confirm_password) {
    echo json_encode(['status' => 'error', 'message' => 'Passwords do not match.']);
    exit;
}
if (strlen($password) < 8) {
    echo json_encode(['status' => 'error', 'message' => 'Password must be at least 8 characters.']);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email format.']);
    exit;
}

// --- 3. Check if User Already Exists ---
try {
    // Correct Code
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'An account with this email or username already exists.']);
        $stmt->close();
        $conn->close();
        exit;
    }
    $stmt->close();
} catch (Exception $e) {
    error_log("DB Check Error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'A database error occurred.']);
    exit;
}


// --- 4. Hash Password and Insert New User ---
// Securely hash the password before storing it
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$role = 'guest'; // Default role for new sign-ups

try {
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, mobile_number, role) VALUES (?, ?, ?, ?, ?)");
    // The types "sssss" mean all 5 variables are strings
    $stmt->bind_param("sssss", $username, $email, $hashed_password, $mobile, $role);

    if ($stmt->execute()) {
        // SUCCESS!
        echo json_encode(['status' => 'success', 'message' => 'Account created successfully! Redirecting to login...']);
    } else {
        throw new Exception("Execute failed: " . $stmt->error);
    }
    $stmt->close();
    
} catch (Exception $e) {
    // Log the detailed error for yourself, but show a generic one to the user.
    error_log("DB Insert Error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Could not register account due to a server error.']);
}

$conn->close();
?>