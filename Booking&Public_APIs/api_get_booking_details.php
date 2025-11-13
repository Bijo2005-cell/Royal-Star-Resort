<?php
// api_get_booking_details.php

ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

function send_json_error($message) {
    echo json_encode(['status' => 'error', 'message' => $message]);
    exit();
}

// 1. Validate the Booking ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    send_json_error('No valid booking ID provided.');
}
$bookingId = intval($_GET['id']);

// 2. Connect to Database
require_once '../Database/db_connect.php';
if ($conn->connect_error) {
    send_json_error('Database connection failed.');
}

// 3. CORRECTED QUERY: Use LEFT JOIN for both tables
$query = "SELECT 
            b.booking_id, b.total_rate,
            bd.check_in, bd.check_out,
            a.number AS room_name, a.price AS room_base_price,
            p.title AS program_name, p.price AS program_price, p.type AS program_type
          FROM bookings AS b
          JOIN booking_details AS bd ON b.booking_id = bd.booking_id
          LEFT JOIN accommodations AS a ON bd.acc_id = a.acc_id
          LEFT JOIN programs AS p ON bd.program_id = p.program_id
          WHERE b.booking_id = ?
          LIMIT 1";

$stmt = $conn->prepare($query);
if (!$stmt) {
    send_json_error('Failed to prepare SQL statement: ' . $conn->error);
}

$stmt->bind_param('i', $bookingId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $details = $result->fetch_assoc();
    $breakdown = [];
    $calculated_subtotal = 0;

    // 4. SAFELY Handle Room Breakdown (if a room was booked)
    if (!empty($details['room_name']) && !empty($details['check_in']) && !empty($details['check_out'])) {
        $checkin = new DateTime($details['check_in']);
        $checkout = new DateTime($details['check_out']);
        // Calculate nights, ensure at least 1 day/night for pricing
        $nights = $checkin->diff($checkout)->days;
        if ($nights <= 0) $nights = 1; 

        $room_total = $nights * (float)$details['room_base_price'];
        $calculated_subtotal += $room_total;

        $breakdown[] = [
            'description' => $details['room_name'] . " (×" . $nights . " " . ($nights > 1 ? "nights" : "night") . ")",
            'amount' => $room_total,
            'is_discount' => false
        ];
    }

    // 5. SAFELY Handle Program Breakdown (if a program was booked)
    if (!empty($details['program_name'])) {
        if ($details['program_type'] == 'offer' && $calculated_subtotal > 0) {
            // Apply offer as a percentage discount *on the room total*
            $discount_amount = $calculated_subtotal * ((float)$details['program_price'] / 100);
            $breakdown[] = [
                'description' => 'Discount (' . $details['program_name'] . ' ' . (int)$details['program_price'] . '%)',
                'amount' => -$discount_amount, // Negative amount
                'is_discount' => true
            ];
        } else if ($details['program_type'] != 'offer') {
            // Add as a separate line item
            $program_cost = (float)$details['program_price'];
            $calculated_subtotal += $program_cost;
            $breakdown[] = [
                'description' => '+ ' . $details['program_name'],
                'amount' => $program_cost,
                'is_discount' => false
            ];
        }
    }
    
    // 6. Add Taxes/Fees
    // This adds a line item for any difference between the subtotal and the final price
    $taxes_and_fees = (float)$details['total_rate'] - $calculated_subtotal;
    if (abs($taxes_and_fees) > 0.01) { // Check for non-zero difference
         $breakdown[] = [
            'description' => 'Taxes & Fees',
            'amount' => $taxes_and_fees,
            'is_discount' => $taxes_and_fees < 0
        ];
    }
    
    // 7. Final Fallback for Display
    // If no room was booked, use the program name as the main display item
    if (empty($details['room_name']) && !empty($details['program_name'])) {
         $details['room_name'] = $details['program_name'];
    } else if (empty($details['room_name'])) {
         $details['room_name'] = 'Booking Confirmation'; // Fallback
    }

    echo json_encode([
        'status' => 'success', 
        'details' => $details,
        'breakdown' => $breakdown
    ]);

} else {
    send_json_error('Booking not found.');
}

$stmt->close();
$conn->close();
?>