<?php
// setup_database.php
require_once '../Database/db_connect.php';

echo "<h3>Database Setup Script</h3>";

// --- SQL to drop existing table (optional, for a clean start) ---
$sql_drop = "DROP TABLE IF EXISTS users";
if ($conn->query($sql_drop) === TRUE) {
    echo "Table 'users' dropped successfully.<br>";
} else {
    echo "Error dropping table: " . $conn->error . "<br>";
}

// --- SQL to create users table ---
$sql_create = "CREATE TABLE users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'employee', 'guest') NOT NULL DEFAULT 'guest',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql_create) === TRUE) {
    echo "Table 'users' created successfully.<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// --- Predefined Users ---
$users = [
    // Admin User
    ['username' => 'admin_user', 'email' => 'bijokbinoy2005@gmail.com', 'password' => 'bijo2005', 'role' => 'admin'],
    // Employee User
    ['username' => 'employee_user', 'email' => 'vasudev@gmail.com', 'password' => 'vasu@123', 'role' => 'employee'],
    // Guest User
    ['username' => 'guest_user', 'email' => 'noyal@gmail.com', 'password' => 'noyal@123', 'role' => 'guest']
];

echo "<h4>Inserting Predefined Users:</h4>";
$stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");

foreach ($users as $user) {
    // Hash the password securely
    $hashed_password = password_hash($user['password'], PASSWORD_DEFAULT);
    
    $stmt->bind_param("ssss", $user['username'], $user['email'], $hashed_password, $user['role']);
    
    if ($stmt->execute()) {
        echo "User '{$user['username']}' created successfully (Password: {$user['password']}).<br>";
    } else {
        echo "Error creating user '{$user['username']}': " . $stmt->error . "<br>";
    }
}

echo "<h4>Setup complete!</h4>";
$stmt->close();
$conn->close();
?>