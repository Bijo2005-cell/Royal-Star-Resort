<?php
session_start();
require '../Database/db_connect.php';

// Security check: Redirect to login if not logged in as an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../Guest&Public_Pages/login.php');
    exit();
}

// --- Report Period Logic ---
$period = isset($_GET['period']) ? $_GET['period'] : 'overall';
$sql_date_filter = "";
$sql_checkin_filter = "";
$period_label = "Overall";
$total_rooms = $conn->query("SELECT COUNT(*) as count FROM accommodations")->fetch_assoc()['count'];

// Date definitions
$today = date('Y-m-d');
$month_start = date('Y-m-01');
$month_end = date('Y-m-t');
$year_start = date('Y-01-01');
$year_end = date('Y-12-31');
$days_in_month = date('t');
$days_in_year = 365; // Use 365 for a full year calculation

// Build SQL filters based on selected period
switch ($period) {
    case 'daily':
        $period_label = "Daily";
        $sql_date_filter = "WHERE DATE(b.booking_date) = CURDATE()";
        // Occupancy: rooms checked in today
        $sql_checkin_filter = "WHERE bd.check_in <= '$today' AND bd.check_out > '$today'";
        $period_days = 1;
        break;
    case 'monthly':
        $period_label = "Monthly";
        $sql_date_filter = "WHERE b.booking_date BETWEEN '$month_start' AND '$month_end'";
        // Occupancy: nights booked within this month
        $sql_checkin_filter = "WHERE bd.check_in <= '$month_end' AND bd.check_out >= '$month_start'";
        $period_days = $days_in_month;
        break;
    case 'yearly':
        $period_label = "Yearly";
        $sql_date_filter = "WHERE b.booking_date BETWEEN '$year_start' AND '$year_end'";
        // Occupancy: nights booked within this year
        $sql_checkin_filter = "WHERE bd.check_in <= '$year_end' AND bd.check_out >= '$year_start'";
        $period_days = $days_in_year;
        break;
    default: // 'overall'
        $period_label = "Overall";
        $sql_date_filter = ""; // No filter
        $sql_checkin_filter = ""; // No filter
        // Get total days from first check-in to last check-out for overall occupancy
        $days_query = $conn->query("SELECT DATEDIFF(MAX(check_out), MIN(check_in)) as days FROM booking_details");
        $period_days = $days_query ? $days_query->fetch_assoc()['days'] : 1;
        if ($period_days == 0) $period_days = 1;
        break;
}


// --- Data Fetching ---

// 1. Key Metrics
$total_bookings = $conn->query("SELECT COUNT(*) as count FROM bookings b $sql_date_filter")->fetch_assoc()['count'];
$total_revenue_query = $conn->query("SELECT SUM(total_rate) as sum FROM bookings b $sql_date_filter");
$total_revenue = $total_revenue_query ? $total_revenue_query->fetch_assoc()['sum'] : 0;
$total_guests_query = $conn->query("SELECT COUNT(*) as count FROM users WHERE role = 'guest'");
$total_guests = $total_guests_query ? $total_guests_query->fetch_assoc()['count'] : 0; // This is total registered guests, not period-specific


// 2. Occupancy Rate
$total_nights_booked = 0;
if ($period == 'daily') {
    // Daily occupancy = (rooms occupied today) / (total rooms)
    $total_nights_booked = $conn->query("SELECT COUNT(*) as count FROM booking_details bd $sql_checkin_filter")->fetch_assoc()['count'];
    $total_room_nights_available = $total_rooms;
} elseif ($period == 'overall') {
    // Overall occupancy = (total nights ever booked) / (total rooms * total days of operation)
    $total_nights_booked_query = $conn->query("SELECT SUM(DATEDIFF(check_out, check_in)) as nights FROM booking_details");
    $total_nights_booked = $total_nights_booked_query ? $total_nights_booked_query->fetch_assoc()['nights'] : 0;
    $total_room_nights_available = $total_rooms * $period_days;
} else {
    // Monthly/Yearly occupancy = (nights booked in period) / (total rooms * days in period)
    $period_start = ($period == 'monthly') ? $month_start : $year_start;
    $period_end = ($period == 'monthly') ? $month_end : $year_end;
    
    $nights_query = $conn->query("
        SELECT SUM(
            DATEDIFF(
                LEAST(check_out, '$period_end'),
                GREATEST(check_in, '$period_start')
            )
        ) as nights
        FROM booking_details bd
        $sql_checkin_filter
    ");
    $total_nights_booked = $nights_query ? $nights_query->fetch_assoc()['nights'] : 0;
    $total_room_nights_available = $total_rooms * $period_days;
}

$occupancy_rate = ($total_room_nights_available > 0) ? ($total_nights_booked / $total_room_nights_available) * 100 : 0;


// 3. Top 5 Performing Accommodations (based on bookings *made* in the period)
$top_accommodations_query = $conn->query(
    "SELECT a.number, a.acc_type, COUNT(bd.acc_id) as booking_count 
     FROM booking_details bd
     JOIN accommodations a ON a.acc_id = bd.acc_id
     JOIN bookings b ON bd.booking_id = b.booking_id
     $sql_date_filter 
     GROUP BY a.acc_id, a.number, a.acc_type
     ORDER BY booking_count DESC
     LIMIT 5"
);

// 4. Booking Sources (FIXED: Now fetches from database)
$booking_sources_query = $conn->query(
    "SELECT source, COUNT(*) as count 
     FROM bookings b
     $sql_date_filter
     GROUP BY source
     ORDER BY count DESC"
);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $period_label; ?> Report - Royal Star Resort</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Styling&Scripts/style1.css">
    <style>
        .report-header {
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 1rem;
            margin-bottom: 2rem;
        }
        .report-section {
            margin-bottom: 2.5rem;
        }
        .metric-card {
            background-color: #f8f9fa;
            border: none;
            border-left: 5px solid #8B4513; /* SaddleBrown */
            padding: 1.5rem;
            text-align: center;
        }
        .metric-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: #8B4513;
        }
        .metric-label {
            font-size: 1rem;
            color: #6c757d;
            text-transform: uppercase;
        }
        /* Ensure active nav pill is styled correctly */
        .nav-pills .nav-link.active {
            background-color: #8B4513;
            color: #fff;
        }
        .nav-pills .nav-link {
            color: #8B4513;
        }
        
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none !important; }
            .report-card { page-break-inside: avoid; }
            .metric-card { page-break-inside: avoid; }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand navbar-dark no-print">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin.php">Royal <span>Star</span> Resort</a>
            <div class="d-flex align-items-center ms-auto">
                 <a class="nav-link" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
                    <i class="fas fa-bars"></i>
                 </a>
            </div>
        </div>
    </nav>

    <div class="offcanvas offcanvas-end no-print" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasMenuLabel">Royal Star Resort</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body offcanvas-menu">
            <nav class="nav flex-column">
                <a class="nav-link" href="../Admin&Staff_Panel/admin.php"><i class="fas fa-home"></i> Home</a>
                <a class="nav-link" href="../Admin&Staff_Panel/room_mang.php"><i class="fas fa-bed"></i> Rooms Management</a>
                <a class="nav-link" href="../Admin&Staff_Panel/program_mang.php"><i class="fas fa-gift"></i> Programs Management</a>
                <a class="nav-link" href="../Admin&Staff_Panel/guest_mang.php"><i class="fas fa-swimming-pool"></i> Guest Management</a>
                <a class="nav-link" href="../Admin&Staff_Panel/employee_mang.php"><i class="fas fa-camera"></i> Staff Management</a>
                <a class="nav-link" href="../Admin&Staff_Panel/salary_mang.php"><i class="fas fa-building"></i> Salary Management</a>
                <a class="nav-link" href="../Admin&Staff_Panel/leave_mang.php"><i class="fas fa-book"></i> Leave Management</a>
                <a class="nav-link active" href="../Admin&Staff_Panel/report_mang.php"><i class="fas fa-chart-line"></i> Reports</a>
                <div class="mt-4 pt-3 border-top"><a href="../Guest&Public_pages/home.php" class="btn btn-outline-danger w-100"><i class="fas fa-sign-out-alt me-2"></i> Log Out</a></div>
            </nav>
        </div>
    </div>

    <main class="container my-5">
        <div class="report-header d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title"><?php echo $period_label; ?> Resort Performance Report</h1>
                <p class="text-muted">Generated on: <?php echo date('d M Y, h:i A'); ?></p>
            </div>
            <button id="printBtn" class="btn btn-primary no-print"><i class="bi bi-printer-fill me-2"></i> Print Report</button>
        </div>
        
        <ul class="nav nav-pills mb-4 no-print" id="reportPeriodTabs">
            <li class="nav-item">
                <a class="nav-link <?php if ($period == 'overall') echo 'active'; ?>" href="report_mang.php?period=overall">Overall</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if ($period == 'daily') echo 'active'; ?>" href="report_mang.php?period=daily">Daily</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if ($period == 'monthly') echo 'active'; ?>" href="report_mang.php?period=monthly">Monthly</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if ($period == 'yearly') echo 'active'; ?>" href="report_mang.php?period=yearly">Yearly</a>
            </li>
        </ul>

        <section class="report-section">
            <h3 class="section-title mb-4">Key Metrics (<?php echo $period_label; ?>)</h3>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="metric-card">
                        <div class="metric-value">₹<?php echo number_format($total_revenue ?? 0, 2); ?></div>
                        <div class="metric-label">Total Revenue</div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="metric-card">
                        <div class="metric-value"><?php echo $total_bookings; ?></div>
                        <div class="metric-label">Total Bookings</div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="metric-card">
                        <div class="metric-value"><?php echo number_format($occupancy_rate, 2); ?>%</div>
                        <div class="metric-label">Occupancy Rate</div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="metric-card">
                        <div class="metric-value"><?php echo $total_guests; ?></div>
                        <div class="metric-label">Total Registered Guests</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="report-section">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card report-card h-100">
                        <div class="card-header"><h5 class="mb-0">Top 5 Accommodations (<?php echo $period_label; ?>)</h5></div>
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead><tr><th>Accommodation</th><th>Type</th><th>Bookings</th></tr></thead>
                                <tbody>
                                    <?php if ($top_accommodations_query->num_rows > 0): ?>
                                        <?php while ($row = $top_accommodations_query->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['number']); ?></td>
                                            <td><span class="badge bg-secondary"><?php echo ucfirst(htmlspecialchars($row['acc_type'])); ?></span></td>
                                            <td><?php echo $row['booking_count']; ?></td>
                                        </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr><td colspan="3" class="text-center">No data for this period.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card report-card h-100">
                        <div class="card-header"><h5 class="mb-0">Bookings by Source (<?php echo $period_label; ?>)</h5></div>
                         <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead><tr><th>Source</th><th>Bookings Count</th></tr></thead>
                                <tbody>
                                    <?php if ($booking_sources_query->num_rows > 0): ?>
                                        <?php while ($row = $booking_sources_query->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['source']); ?></td>
                                            <td><?php echo $row['count']; ?></td>
                                        </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr><td colspan="2" class="text-center">No data for this period.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple script to trigger the browser's print dialog
        document.getElementById('printBtn').addEventListener('click', () => {
            window.print();
        });
    </script>
</body>
</html>