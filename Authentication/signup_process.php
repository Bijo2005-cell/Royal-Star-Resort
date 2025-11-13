<?php
session_start();
require_once '../Database/db_connect.php';

// Initialize response array
$response = array();

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'] ?? '';
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $mobile = $_POST['mobile'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Validate input
    if (empty($name) || empty($username) || empty($email) || empty($password)) {
        $response['status'] = 'error';
        $response['message'] = 'All fields except mobile are required';
    } else {
        // Check if username already exists
        $check_username = "SELECT id FROM user WHERE username = ?";
        $stmt = $conn->prepare($check_username);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $response['status'] = 'error';
            $response['message'] = 'Username already exists';
        } else {
            // Check if email already exists
            $check_email = "SELECT id FROM user WHERE email = ?";
            $stmt = $conn->prepare($check_email);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $response['status'] = 'error';
                $response['message'] = 'Email already exists';
            } else {
                // Hash password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                // Insert new user
                $insert_sql = "INSERT INTO user (name, username, email, password, mobile) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($insert_sql);
                $stmt->bind_param("sssss", $name, $username, $email, $hashed_password, $mobile);
                
                if ($stmt->execute()) {
                    // Registration successful
                    $user_id = $stmt->insert_id;
                    
                    // Set session variables
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['user_name'] = $name;
                    $_SESSION['user_email'] = $email;
                    
                    $response['status'] = 'success';
                    $response['message'] = 'Registration successful';
                    $response['redirect'] = 'home.php';
                } else {
                    // Registration failed
                    $response['status'] = 'error';
                    $response['message'] = 'Registration failed: ' . $conn->error;
                }
            }
        }
        
        $stmt->close();
    }
} else {
    // Not a POST request
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method';
}

// Close database connection
$conn->close();

// Set proper content type for JSON response
header('Content-Type: application/json');

// Return JSON response
echo json_encode($response);
exit;
?>