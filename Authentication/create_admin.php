<?php
require '../Database/db_connect.php'; // Your database connection file

// --- SET YOUR ADMIN CREDENTIALS HERE ---
$admin_email = "bijokbinoy2005@gmail.com";
$admin_password = "bijo2005";
$admin_full_name = "Administrator";
// -----------------------------------------

// Generate a secure password hash
$password_hash = password_hash($admin_password, PASSWORD_BCRYPT);

// Prepare the SQL statement to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO admins (email, password_hash, full_name) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $admin_email, $password_hash, $admin_full_name);

if ($stmt->execute()) {
    echo "Admin user created successfully!";
} else {
    echo "Error creating admin user: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>