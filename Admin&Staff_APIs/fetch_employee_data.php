<?php
session_start();
// --- THIS IS THE FIX ---
// It needs to go up one level from Admin&Staff_APIs to find the Database folder
include '../Database/db_connect.php'; 

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    echo json_encode(['error' => 'Authentication failed']);
    exit();
}

$user_id = $_SESSION['user_id'];
$query_type = $_GET['query'] ?? '';

switch ($query_type) {

    // 1. WELCOME STATS
    case 'welcome_stats':
        // Fetch user info
        $stmt = $conn->prepare("SELECT username, department FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $user_data = $stmt->get_result()->fetch_assoc();

        // Fetch occupancy
        $occ_sql = "SELECT 
                        (SELECT COUNT(*) FROM accommodations WHERE status = 'occupied') AS occupied_count,
                        (SELECT COUNT(*) FROM accommodations) AS total_count";
        $occ_result = $conn->query($occ_sql)->fetch_assoc();
        $occupancy = ($occ_result['total_count'] > 0) ? round(($occ_result['occupied_count'] * 100) / $occ_result['total_count']) : 0;

        // VIP guests (placeholder, as this logic isn't in the DB schema)
        $vip_guests = 3; // You can change this to a real query if you add VIP logic

        echo json_encode([
            'username' => $user_data['username'],
            'department' => $user_data['department'],
            'occupancy' => $occupancy,
            'vip_guests' => $vip_guests
        ]);
        break;

    // 2. TASKS (This is the new part)
    case 'tasks':
        // This query is correct based on your database
        $stmt = $conn->prepare("SELECT * FROM tasks WHERE assigned_to_user_id = ? AND status = 'Pending' ORDER BY due_date ASC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $tasks = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        echo json_encode($tasks);
        break;

    // 3. GUEST STATUS
    case 'guest_status':
        // This query is correct based on your database
        $sql = "SELECT 
                    b.guest_name, 
                    bd.check_in, 
                    bd.check_out, 
                    a.number AS room_number, 
                    p.title AS program_title,
                    CASE 
                        WHEN bd.check_in = CURDATE() THEN 'CheckedIn'
                        WHEN bd.check_out < CURDATE() THEN 'CheckedOut'
                        ELSE 'Confirmed'
                    END AS status
                FROM bookings b
                JOIN booking_details bd ON b.booking_id = bd.booking_id
                LEFT JOIN accommodations a ON bd.acc_id = a.acc_id
                LEFT JOIN programs p ON bd.program_id = p.program_id
                WHERE b.status = 'Confirmed'
                ORDER BY bd.check_in DESC
                LIMIT 5";
        
        $result = $conn->query($sql);
        $guests = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($guests);
        break;

    // 4. RECENT ACTIVITY (From the new log table)
    case 'recent_activity':
        // This query is correct based on your database
        $sql = "SELECT al.*, u.username 
                FROM activity_log al
                LEFT JOIN users u ON al.user_id = u.id
                ORDER BY al.timestamp DESC
                LIMIT 5";
        $result = $conn->query($sql);
        $activities = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($activities);
        break;

    default:
        echo json_encode(['error' => 'Invalid query']);
        break;
}

$conn->close();
?>