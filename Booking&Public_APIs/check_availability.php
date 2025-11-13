<?php
header('Content-Type: application/json');

// --- Database Connection ---
// !! IMPORTANT: Replace with your actual database connection details
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "royal_star_resort";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

// Check if dates are provided
if (!isset($_GET['check_in']) || !isset($_GET['check_out'])) {
    echo json_encode(['unavailable_ids' => []]); // Return empty if no dates
    exit;
}

$checkIn = $_GET['check_in'];
$checkOut = $_GET['check_out'];

// Validate dates
if (empty($checkIn) || empty($checkOut) || $checkOut <= $checkIn) {
    echo json_encode(['unavailable_ids' => []]); // Return empty for invalid range
    exit;
}

$unavailableIds = [];

try {
    // Query 1: Get rooms unavailable due to 'occupied' or 'maintenance' status in the accommodations table
    $stmt1 = $conn->prepare("SELECT acc_id FROM accommodations WHERE status IN ('occupied', 'maintenance')");
    $stmt1->execute();
    while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        $unavailableIds[] = $row['acc_id'];
    }

    // Query 2: Get rooms unavailable due to conflicting 'Confirmed' bookings
    // A conflict exists if (StartA < EndB) and (EndA > StartB)
    $sql = "SELECT DISTINCT bd.acc_id 
            FROM booking_details bd
            JOIN bookings b ON bd.booking_id = b.booking_id
            WHERE bd.acc_id IS NOT NULL
            AND b.status = 'Confirmed'
            AND (bd.check_in < :check_out AND bd.check_out > :check_in)";
            
    $stmt2 = $conn->prepare($sql);
    $stmt2->bindParam(':check_in', $checkIn);
    $stmt2->bindParam(':check_out', $checkOut);
    $stmt2->execute();

    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        if (!in_array($row['acc_id'], $unavailableIds)) {
            $unavailableIds[] = $row['acc_id'];
        }
    }

    echo json_encode(['unavailable_ids' => array_map('intval', $unavailableIds)]);

} catch(PDOException $e) {
    echo json_encode(['error' => 'Query failed: ' . $e->getMessage()]);
}

$conn = null; // Close connection
?>