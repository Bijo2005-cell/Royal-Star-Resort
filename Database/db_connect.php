<?php
// /includes/db_connect.php

/**
 * Database connection file for Royal Star Resort project
 */

// --- Database Credentials ---
$servername = "localhost";          // Usually "localhost" for XAMPP
$username   = "root";               // Default XAMPP username
$password   = "";                   // Default XAMPP password is empty
$dbname     = "royal_star_resort";  // Your database name

// --- Create and Check Connection ---
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    // Log error (for debugging in XAMPP logs)
    error_log("Database connection failed: " . $conn->connect_error);

    // Return JSON error instead of die()
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'message' => 'Database connection failed. Please try again later.'
    ]);
    exit; // Stop execution
}

// --- Set Character Set ---
$conn->set_charset("utf8mb4");
?>