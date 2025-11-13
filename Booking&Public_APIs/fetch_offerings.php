<?php
// Include database connection file
require_once '../Database/db_connect.php';

// Set the header to indicate JSON content
header('Content-Type: application/json');

// Array to hold the fetched items
$items = [];

// SQL query to fetch all offerings
$sql = "SELECT id, type, title, description, price, dates, image FROM offerings";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    // Fetch all results into an associative array
    while($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
}

// Close the database connection
$conn->close();

// Encode the PHP array into a JSON string and output it
echo json_encode($items);
?>