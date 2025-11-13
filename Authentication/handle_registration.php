<?php
// Set the content type to JSON at the very beginning
header('Content-Type: application/json');

require '../Database/db_connect.php'; // Your database connection file

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

// --- Data Collection and Basic Validation ---
$email = $_POST['email'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';
$mobile = $_POST['mobile_number'] ?? '';

if (empty($email) || empty($username) || empty($password) || empty($mobile)) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email format.']);
    exit;
}

if ($password !== $confirm_password) {
    echo json_encode(['status' => 'error', 'message' => 'Passwords do not match.']);
    exit;
}

// --- Check for Existing User ---
$stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ? OR username = ?");
$stmt->bind_param("ss", $email, $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Email or Username already exists.']);
    $stmt->close();
    $conn->close();
    exit;
}
$stmt->close();

// --- Hash Password and Insert New User ---
// Use PASSWORD_DEFAULT for strong, modern hashing
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// The default role for a new registration is 'guest'
$role = 'guest';

$stmt = $conn->prepare("INSERT INTO users (email, username, password, mobile_number, role) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $email, $username, $hashed_password, $mobile, $role);

if ($stmt->execute()) {
    // SUCCESS
    echo json_encode(['status' => 'success', 'message' => 'Account created successfully! You can now log in.']);
} else {
    // FAILURE
    error_log("Registration Error: " . $stmt->error); // Log the actual error for debugging
    echo json_encode(['status' => 'error', 'message' => 'An error occurred. Please try again.']);
}

$stmt->close();
$conn->close();
?>