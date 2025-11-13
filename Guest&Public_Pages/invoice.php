<?php
// invoice.php

// --- Fetch Booking Details ---
$bookingId = $_GET['id'] ?? 0;
if (!$bookingId || !is_numeric($bookingId)) {
    die("Invalid Booking ID provided.");
}

require_once '../Database/db_connect.php';

if ($conn->connect_error) {
    // This line was fixed. Removed extra double-quote.
    die("Database Connection Failed: " . $conn->connect_error);
}

// This query joins all necessary tables to build a complete invoice
$query = "SELECT 
            b.booking_id, b.total_rate, b.booking_date,
            bd.check_in, bd.check_out,
            a.number AS room_name, a.price AS room_base_price,
            p.title AS program_name, p.price AS program_price, p.type AS program_type
          FROM bookings AS b
          JOIN booking_details AS bd ON b.booking_id = bd.booking_id
          JOIN accommodations AS a ON bd.acc_id = a.acc_id
          LEFT JOIN programs AS p ON bd.program_id = p.program_id
          WHERE b.booking_id = ?";

$stmt = $conn->prepare($query);
if (!$stmt) {
    die("SQL Prepare Failed: " . $conn->error);
}

$stmt->bind_param('i', $bookingId);
$stmt->execute();
$result = $stmt->get_result();
$details = $result->fetch_assoc();

$stmt->close();
$conn->close();

if (!$details) {
    die("Booking with ID #" . htmlspecialchars($bookingId) . " not found.");
}

// Calculate number of nights for price breakdown
$checkin = new DateTime($details['check_in']);
$checkout = new DateTime($details['check_out']);
$nights = $checkin->diff($checkout)->days;
$room_total = $nights > 0 ? ($nights * $details['room_base_price']) : $details['room_base_price'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #<?php echo htmlspecialchars($details['booking_id']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #8B4513;
        }
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #e9ecef; 
        }
        .invoice-container { 
            max-width: 850px; 
            margin: 2rem auto; 
            background: #fff; 
            border: 1px solid #dee2e6; 
            box-shadow: 0 0 20px rgba(0,0,0,.07); 
        }
        .invoice-header { 
            background-color: var(--primary-color); 
            color: white; 
            padding: 2.5rem 3rem; 
            border-bottom: 5px solid #D4AF37;
        }
        .invoice-header h1 { 
            font-family: 'Playfair Display', serif; 
            margin: 0; 
            font-size: 2.5rem;
        }
        .invoice-body { padding: 3rem; }
        .invoice-footer { 
            text-align: center; 
            padding: 2rem; 
            font-size: 0.9em; 
            color: #6c757d; 
            background-color: #f8f9fa;
        }
        .print-btn-container { 
            text-align: center; 
            padding: 1.5rem;
        }
        .btn-print {
            background-color: var(--primary-color);
            color: white;
            border: none;
        }

        @media print {
            body { background-color: #fff; }
            .invoice-container { margin: 0; box-shadow: none; border: none; max-width: 100%;}
            .print-btn-container { display: none; }
        }
    </style>
</head>
<body>
    <div class="print-btn-container">
        <button onclick="history.back()" class="btn btn-secondary btn-lg me-2">⬅️ Go Back</button>
        <button onclick="window.print()" class="btn btn-print btn-lg">🖨️ Print Invoice</button>
    </div>

    <div class="invoice-container">
        <div class="invoice-header">
            <div class="row align-items-center">
                <div class="col-8">
                    <h1>Invoice</h1>
                    <div class="text-white-50">Royal Star Resort</div>
                </div>
                <div class="col-4 text-end">
                    <div><strong>Booking ID:</strong> #<?php echo htmlspecialchars($details['booking_id']); ?></div>
                    <div><strong>Date:</strong> <?php echo date("d M, Y", strtotime($details['booking_date'])); ?></div>
                </div>
            </div>
        </div>
        <div class="invoice-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <strong>Billed To:</strong>
                    <address class="mt-2 text-muted">
                        Valued Guest<br>
                        (Contact details are kept private)
                    </address>
                </div>
                <div class="col-md-6 text-md-end">
                    <strong>Resort Details:</strong>
                    <address class="mt-2 text-muted">
                        Royal Star Resort<br>
                        123 Scenic Valley Road<br>
                        Munnar, Kerala, India
                    </address>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-md-6">
                    <h5><strong>Check-in:</strong> <?php echo date("l, d F Y", strtotime($details['check_in'])); ?></h5>
                </div>
                <div class="col-md-6 text-md-end">
                     <h5><strong>Check-out:</strong> <?php echo date("l, d F Y", strtotime($details['check_out'])); ?></h5>
                </div>
            </div>

            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th class="p-3">Description</th>
                        <th class="text-end p-3">Rate</th>
                        <th class="text-center p-3">Nights</th>
                        <th class="text-end p-3">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="p-3"><?php echo htmlspecialchars($details['room_name']); ?></td>
                        <td class="text-end p-3">₹<?php echo number_format($details['room_base_price'], 2); ?></td>
                        <td class="text-center p-3"><?php echo $nights; ?></td>
                        <td class="text-end p-3">₹<?php echo number_format($room_total, 2); ?></td>
                    </tr>
                    <?php 
                    if ($details['program_name']) {
                        if ($details['program_type'] == 'offer') {
                            $discount_amount = $room_total * ($details['program_price'] / 100);
                            echo '<tr><td colspan="3" class="text-end border-0 p-2"><strong>Discount (' . htmlspecialchars($details['program_name']) . ' ' . (int)$details['program_price'] . '%)</strong></td><td class="text-end text-success p-2">- ₹' . number_format($discount_amount, 2) . '</td></tr>';
                        } else {
                             echo '<tr><td colspan="3" class="text-end border-0 p-2"><strong>' . htmlspecialchars($details['program_name']) . '</strong></td><td class="text-end p-2">+ ₹' . number_format($details['program_price'], 2) . '</td></tr>';
                        }
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr class="table-light">
                        <th colspan="3" class="text-end p-3">Grand Total</th>
                        <th class="text-end h4 mb-0 p-3">₹<?php echo number_format($details['total_rate'], 2); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="invoice-footer">
            Thank you for choosing Royal Star Resort. We look forward to welcoming you!
        </div>
    </div>
</body>
</html>