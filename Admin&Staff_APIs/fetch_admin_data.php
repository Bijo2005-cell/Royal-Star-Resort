<?php
session_start();
// Assuming db_connect.php is in a directory like 'Database' relative to this file's parent
require '../Database/db_connect.php'; 

// Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'Access Denied']);
    exit;
}

header('Content-Type: application/json');

$query_type = isset($_GET['query']) ? $_GET['query'] : '';
$data = [];

switch ($query_type) {
    case 'stats':
        // Available Rooms
        // Corrected table name from 'accommodation' to 'accommodations'
        $result = $conn->query("SELECT COUNT(*) as count FROM accommodations WHERE status = 'available'");
        $data['available_rooms'] = $result->fetch_assoc()['count'];
        
        // Current Bookings
        // Corrected table name and joined with 'booking_details' for dates
        $result = $conn->query("SELECT COUNT(DISTINCT b.booking_id) as count FROM bookings b
                                JOIN booking_details bd ON b.booking_id = bd.booking_id
                                WHERE b.status = 'Confirmed' AND bd.check_out >= CURDATE()");
        $data['current_bookings'] = $result->fetch_assoc()['count'];

        // Checkouts Today
        // Corrected table name and joined with 'booking_details' for dates
        $result = $conn->query("SELECT COUNT(DISTINCT b.booking_id) as count FROM bookings b
                                JOIN booking_details bd ON b.booking_id = bd.booking_id
                                WHERE bd.check_out = CURDATE()");
        $data['checkouts_today'] = $result->fetch_assoc()['count'];

        // Cancellations (in the last 7 days)
        // Corrected table name from 'booking' to 'bookings'
        $result = $conn->query("SELECT COUNT(*) as count FROM bookings 
                                WHERE status = 'Cancelled' AND booking_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)");
        $data['cancellations'] = $result->fetch_assoc()['count'];
        break;

    case 'revenue_trend':
        // Corrected query to join 'bookings' and 'booking_details'
        // Used 'total_rate' instead of 'total_price'
        $result = $conn->query("SELECT MONTH(bd.check_in) as month, SUM(b.total_rate) as revenue 
                                FROM bookings b
                                JOIN booking_details bd ON b.booking_id = bd.booking_id
                                WHERE YEAR(bd.check_in) = YEAR(CURDATE()) AND b.status = 'Confirmed'
                                GROUP BY MONTH(bd.check_in) 
                                ORDER BY month ASC");
        
        $revenue_data = array_fill(1, 12, 0); // Initialize all 12 months to 0
        while($row = $result->fetch_assoc()) {
            $revenue_data[(int)$row['month']] = (float)$row['revenue'];
        }
        $data = array_values($revenue_data); // Return just the array of revenue values
        break;

    case 'booking_sources':
        // This query cannot be run as your 'bookings' table is missing a 'source' column.
        // We will return empty data to avoid breaking the JavaScript.
        // The hardcoded chart in admin.php will be used instead.
        $data = [
            'labels' => [],
            'counts' => []
        ];
        break;

    case 'recent_bookings':
        // Corrected query to join 'bookings', 'booking_details', 'accommodations', and 'programs'
        $sql = "SELECT b.booking_id, b.guest_name, 
                       COALESCE(a.number, p.title) as item_name, 
                       bd.check_in, bd.check_out 
                FROM bookings b 
                JOIN booking_details bd ON b.booking_id = bd.booking_id
                LEFT JOIN accommodations a ON bd.acc_id = a.acc_id
                LEFT JOIN programs p ON bd.program_id = p.program_id
                WHERE b.guest_name IS NOT NULL AND b.guest_name != ''
                ORDER BY b.booking_date DESC 
                LIMIT 5";
        
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        break;
        
    default:
        http_response_code(400); // Bad Request
        $data = ['error' => 'Invalid query type'];
        break;
}

echo json_encode($data);
$conn->close();
?>