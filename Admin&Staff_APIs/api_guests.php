<?php
session_start();
require '../Database/db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['staff', 'admin'])) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Access Denied']);
    exit;
}

$action = $_REQUEST['action'] ?? '';

switch ($action) {
    case 'fetch_guests':
        fetch_guests($conn);
        break;
    case 'fetch_rooms':
        fetch_rooms($conn);
        break;
    case 'add_guest':
        add_guest($conn);
        break;
    case 'update_booking':
        update_booking($conn);
        break;
    case 'delete_booking':
        delete_booking($conn);
        break;
    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action specified.']);
        break;
}

function fetch_rooms($conn) {
    $sql = "SELECT acc_id, number, price FROM accommodations WHERE status = 'available' ORDER BY number";
    $result = $conn->query($sql);
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
}

function add_guest($conn) {
    $conn->begin_transaction();
    try {
        $email = $_POST['email'];
        // FIX: Select the 'id' column, not 'user_id'
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // FIX: Fetch the 'id' column
            $user_id = $result->fetch_assoc()['id'];
        } else {
            $stmt = $conn->prepare("INSERT INTO users (email, username, password, mobile_number, role) VALUES (?, ?, ?, ?, 'guest')");
            $username = $_POST['first_name'] . ' ' . $_POST['last_name'];
            $hashed_password = password_hash('password123', PASSWORD_DEFAULT);
            $stmt->bind_param("ssss", $email, $username, $hashed_password, $_POST['phone']);
            $stmt->execute();
            $user_id = $conn->insert_id;
        }

        $acc_id = (int)$_POST['acc_id'];
        $check_in = new DateTime($_POST['check_in']);
        $check_out = new DateTime($_POST['check_out']);
        $nights = max(1, $check_out->diff($check_in)->days);

        $stmt = $conn->prepare("SELECT price FROM accommodations WHERE acc_id = ?");
        $stmt->bind_param("i", $acc_id);
        $stmt->execute();
        $total_rate = $nights * $stmt->get_result()->fetch_assoc()['price'];

        $stmt = $conn->prepare("INSERT INTO bookings (user_id, total_rate) VALUES (?, ?)");
        $stmt->bind_param("id", $user_id, $total_rate);
        $stmt->execute();
        $booking_id = $conn->insert_id;

        $stmt = $conn->prepare("INSERT INTO booking_details (booking_id, acc_id, check_in, check_out) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $booking_id, $acc_id, $_POST['check_in'], $_POST['check_out']);
        $stmt->execute();

        $conn->commit();
        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

function update_booking($conn) {
    // Note: This simplified update only changes the booking details, not the user or total rate.
    $bd_id = (int)$_POST['bd_id'];
    $acc_id = (int)$_POST['acc_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    
    $stmt = $conn->prepare("UPDATE booking_details SET acc_id = ?, check_in = ?, check_out = ? WHERE bd_id = ?");
    $stmt->bind_param("issi", $acc_id, $check_in, $check_out, $bd_id);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }
}

function delete_booking($conn) {
    // This simplified delete removes the booking detail. For a full system, you might also delete the parent booking if it has no other details.
    $bd_id = (int)$_POST['bd_id'];
    $stmt = $conn->prepare("DELETE FROM booking_details WHERE bd_id = ?");
    $stmt->bind_param("i", $bd_id);
     if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }
}

function fetch_guests($conn) {
    $sql = "SELECT 
                bd.bd_id as id,
                u.username as guest_name,
                u.email as guest_email,
                u.mobile_number as guest_phone,
                bd.check_in,
                bd.check_out,
                acc.number as room_name,
                acc.acc_id as room_id
            FROM booking_details bd
            JOIN bookings b ON bd.booking_id = b.booking_id
            JOIN users u ON b.user_id = u.id -- <<< FIX: Join on u.id instead of u.user_id
            LEFT JOIN accommodations acc ON bd.acc_id = acc.acc_id
            WHERE u.role = 'guest'
            ORDER BY bd.check_in DESC";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
}

$conn->close();
?>