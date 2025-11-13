<?php
// api_process_booking.php
session_start();
header('Content-Type: application/json');

function send_json_error($message) {
    echo json_encode(['status' => 'error', 'message' => $message]);
    exit();
}

require_once '../Database/db_connect.php';
if ($conn->connect_error) {
    send_json_error('Database connection failed.');
}

// --- Validation for FormData ---
if (empty($_POST) && empty($_FILES)) {
    send_json_error('No data received.');
}
if ((!isset($_POST['roomId']) || $_POST['roomId'] == 'null') && (!isset($_POST['programId']) || $_POST['programId'] == 'null') && empty(json_decode($_POST['selectedPackages'], true))) {
    send_json_error('Invalid booking data: A room or package must be selected.');
}

// --- THE REAL USER ID LOGIC ---
if (!isset($_SESSION['user_id'])) {
    send_json_error('User is not logged in.');
}
$user_role = $_SESSION['role'] ?? 'guest'; 
$user_id_for_booking = $_SESSION['user_id'];
if (
    ($user_role === 'admin' || $user_role === 'staff') &&
    !empty($_POST['guest_user_id'])
) {
    $user_id_for_booking = (int)$_POST['guest_user_id'];
}
// --- END OF FIX ---

// --- Get booking details from POST data ---
$room_id = !empty($_POST['roomId']) && $_POST['roomId'] !== 'null' ? (int)$_POST['roomId'] : null;
$check_in = !empty($_POST['checkin']) && $_POST['checkin'] !== 'null' ? $_POST['checkin'] : null;
$check_out = !empty($_POST['checkout']) && $_POST['checkout'] !== 'null' ? $_POST['checkout'] : null;
$fullName = $_POST['fullName'] ?? null;
$email = $_POST['email'] ?? null;
$phone = $_POST['phone'] ?? null;
$nationality = $_POST['nationality'] ?? null;
$requests = $_POST['requests'] ?? null;
$total_price = (float)($_POST['totalPrice'] ?? 0);

$conn->begin_transaction();

try {

    // =================================================================
    // START: NEW AVAILABILITY CHECK BLOCK
    // =================================================================
    if ($room_id !== null && $check_in !== null && $check_out !== null) {
        
        // This query checks for any booking for the SAME room (acc_id)
        // that overlaps with the new booking dates.
        $availability_sql = "SELECT COUNT(*) as conflict_count 
                             FROM booking_details 
                             WHERE acc_id = ? 
                             AND (? < check_out) 
                             AND (? > check_in)";
                             
        $stmt_check = $conn->prepare($availability_sql);
        $stmt_check->bind_param("iss", $room_id, $check_in, $check_out);
        $stmt_check->execute();
        $result = $stmt_check->get_result();
        $row = $result->fetch_assoc();
        $stmt_check->close();

        // Your database schema shows each room is unique, so quantity is 1.
        // If the count is 1 or more, it's booked.
        if ($row['conflict_count'] > 0) {
            // Throw an exception to stop the booking and trigger the rollback.
            throw new Exception("This accommodation is already booked for the selected dates. Please choose different dates.");
        }
    }
    // =================================================================
    // END: NEW AVAILABILITY CHECK BLOCK
    // =================================================================


    // --- Handle File Upload ---
    $identity_document_path = null;
    if (isset($_FILES['identity_document']) && $_FILES['identity_document']['error'] == 0) {
        $upload_dir = __DIR__ . '/../uploads/documents/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $file_extension = pathinfo($_FILES['identity_document']['name'], PATHINFO_EXTENSION);
        $file_name = uniqid('doc_', true) . '.' . $file_extension;
        $target_path = $upload_dir . $file_name;
        
        if (move_uploaded_file($_FILES['identity_document']['tmp_name'], $target_path)) {
            $identity_document_path = 'uploads/documents/' . $file_name;
        } else {
            throw new Exception("Failed to move uploaded identity document.");
        }
    }

    // --- Modified SQL to include new columns ---
    $bookings_sql = "INSERT INTO bookings 
                        (user_id, guest_name, guest_email, guest_phone, guest_nationality, identity_document, special_requests, total_rate, booking_date) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    
    $stmt1 = $conn->prepare($bookings_sql);

    // --- UPDATED bind_param with $user_id_for_booking ---
    $stmt1->bind_param("issssssd", $user_id_for_booking, $fullName, $email, $phone, $nationality, $identity_document_path, $requests, $total_price);
    
    $stmt1->execute();
    $new_booking_id = $conn->insert_id;
    
    if ($new_booking_id == 0) throw new Exception("Failed to create a new booking record.");

    // --- Insert into the `booking_details` table ---
    $details_sql = "INSERT INTO booking_details (booking_id, acc_id, program_id, check_in, check_out) VALUES (?, ?, ?, ?, ?)";
    $stmt2 = $conn->prepare($details_sql);
    
    $program_id = null;
    $selectedPackages = isset($_POST['selectedPackages']) ? json_decode($_POST['selectedPackages'], true) : [];

    if (!empty($_POST['programId']) && $_POST['programId'] !== 'null') {
        $program_id = (int) str_replace('prog_', '', $_POST['programId']);
    } else if (!empty($selectedPackages)) {
        // Fallback to first selected package if main programId isn't set
        $program_id = (int) str_replace('prog_', '', $selectedPackages[0]['id']);
    }
    
    if ($room_id === null && $program_id === null) {
        throw new Exception("Cannot create a booking detail without a room or a program.");
    }
    
    // Use the variables from the top of the script
    $stmt2->bind_param("iiiss", $new_booking_id, $room_id, $program_id, $check_in, $check_out);
    $stmt2->execute();

    $conn->commit();

    echo json_encode(['status' => 'success', 'message' => 'Booking created!', 'booking_id' => $new_booking_id]);

} catch (Exception $e) {
    $conn->rollback();
    send_json_error($e->getMessage());
} finally {
    if (isset($stmt1)) $stmt1->close();
    if (isset($stmt2)) $stmt2->close();
    $conn->close();
}
?>