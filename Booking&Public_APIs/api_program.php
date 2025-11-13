<?php
// /Booking&Public_APIs/api_program.php

// Set header to return JSON
header('Content-Type: application/json');

// --- FIXED PATH ---
include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/Database/db_connect.php';

// --- Handle Connection Error ---
if (!isset($conn) || $conn->connect_error) {
     echo json_encode([
        'status' => 'error',
        'message' => 'Database connection failed. Check db_connect.php.'
    ]);
    exit;
}

// Get dates from the URL (query parameters)
$check_in = $_GET['check_in'] ?? null;
$check_out = $_GET['check_out'] ?? null;

// Basic validation
if (!$check_in || !$check_out) {
    echo json_encode(['status' => 'error', 'message' => 'Missing dates.']);
    exit;
}

$available_ids = [];

// SQL: Select programs that are always available OR overlap with the selected dates
$sql = "SELECT program_id
        FROM programs
        WHERE
            (valid_from IS NULL AND valid_to IS NULL)
        OR
            (
                ? <= valid_to AND
                ? >= valid_from
            )";

if ($stmt = $conn->prepare($sql)) {
    // Bind parameters (ss = two strings)
    $stmt->bind_param("ss", $check_in, $check_out);
    
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $available_ids[] = (int)$row['program_id'];
    }
    
    $stmt->close();
    
    echo json_encode([
        'status' => 'success',
        'available_ids' => $available_ids
    ]);

} else {
    // SQL error
    echo json_encode(['status' => 'error', 'message' => 'Database query failed.']);
}

$conn->close();
?>