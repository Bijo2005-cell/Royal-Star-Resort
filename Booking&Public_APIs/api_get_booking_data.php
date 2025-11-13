<?php
// api_get_booking_data.php

ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

function send_error($message) {
    echo json_encode(['status' => 'error', 'message' => $message]);
    exit();
}

// CORRECTED LINE: Added a directory separator '/'
require_once __DIR__ . '/../Database/db_connect.php';

if (!isset($conn) || $conn->connect_error) {
    send_error("Database connection failed: " . (isset($conn) ? $conn->connect_error : 'Unknown error'));
}

$response = [
    'status' => 'success',
    'rooms' => [],
    'packages' => [],
    'bookings' => []
];

try {
    // 1. Fetch rooms/villas from 'accommodations' table
    $roomQuery = "SELECT acc_id as id, number as name, description, price, '2' AS maxGuests, image 
                  FROM accommodations 
                  WHERE acc_type IN ('room', 'villa')";

    $result = $conn->query($roomQuery);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $response['rooms'][] = $row;
        }
    } else {
        throw new Exception("Failed to fetch rooms: " . $conn->error);
    }

    // 2. Fetch packages from your 'programs' table
  $programQuery = "SELECT program_id AS id, title AS name, description, price, type, image FROM programs";
    $programResult = $conn->query($programQuery);
    if ($programResult) {
        while ($item = $programResult->fetch_assoc()) {
            $item['id'] = 'prog_' . $item['id']; 
            $response['packages'][] = $item;
        }
    } else {
        throw new Exception("Failed to fetch packages from programs table: " . $conn->error);
    }

    // 3. Fetch existing bookings from your 'booking_details' table
    // This query now uses the correct table and column names from your screenshot
    $bookingQuery = "SELECT acc_id AS roomId, check_in AS checkin, check_out AS checkout 
                     FROM booking_details";

    $bookingResult = $conn->query($bookingQuery);
    if ($bookingResult) {
        while ($booking = $bookingResult->fetch_assoc()) {
            $response['bookings'][] = $booking;
        }
    } else {
        throw new Exception("Failed to fetch bookings: " . $conn->error);
    }

} catch (Exception $e) {
    $conn->close();
    send_error($e->getMessage());
}

$conn->close();
echo json_encode($response);