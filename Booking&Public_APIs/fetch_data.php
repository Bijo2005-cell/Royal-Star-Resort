<?php
// -----------------------------
// --- fetch_data.php (Revised) ---
// -----------------------------

// Include the database connection file
require '../Database/db_connect.php';

// Set the header to indicate the response is JSON
header('Content-Type: application/json');

// Get the requested data type from the URL (e.g., fetch_data.php?type=rooms)
$type = isset($_GET['type']) ? $_GET['type'] : '';

$data = [];
$sql = '';

if ($type === 'rooms') {
    // Fetch the 4 best-selling rooms from the 'accommodation' table
    $sql = "SELECT id, name, price, description, image_path FROM accommodation LIMIT 4";
} 
elseif ($type === 'offers') {
    // Fetch 3 active offers from the 'programs' table
    $sql = "SELECT name, discount_percentage, description, image_path, validity_to 
            FROM programs 
            WHERE program_type = 'offer' AND validity_to >= CURDATE() 
            LIMIT 3";
} 
elseif ($type === 'packages') {
    // Fetch 3 packages from the 'programs' table
    $sql = "SELECT name, price, duration_nights, features, image_path 
            FROM programs 
            WHERE program_type = 'package' 
            LIMIT 3";
} 
else {
    // If type is not recognized, return an error
    echo json_encode(['error' => 'Invalid data type requested']);
    exit;
}

$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    // Return an error if the query failed
     echo json_encode(['error' => 'Database query failed: ' . $conn->error]);
     exit;
}

// Close the connection
$conn->close();

// Encode the fetched data as JSON and send it as the response
echo json_encode($data);
?>