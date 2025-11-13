<?php
// ---------------------------------
// --- fetch_accommodations.php ---
// ---------------------------------

require '../Database/db_connect.php';

header('Content-Type: application/json');

// Get the category ('Room' or 'Villa') from the request URL
$category = isset($_GET['category']) ? $_GET['category'] : '';

if (empty($category)) {
    echo json_encode(['error' => 'Category not specified.']);
    exit;
}

// Use a prepared statement to prevent SQL injection
$stmt = $conn->prepare("SELECT id, name, price, size_sqft, description, image_path, badge_text FROM accommodation WHERE category = ? ORDER BY price");
$stmt->bind_param("s", $category);
$stmt->execute();
$result = $stmt->get_result();

$accommodations = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $accommodations[] = $row;
    }
}

$stmt->close();
$conn->close();

echo json_encode($accommodations);
?>