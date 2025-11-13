<?php
session_start();

// Security check: Redirect to login if not logged in as an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../Guest&Public_Pages/login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Royal Star Residency - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
   <link rel="stylesheet" href="../Styling&Scripts/style1.css">
</head>
<body>
    <nav class="navbar navbar-expand navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Royal <span>Star</span> Resort</a>
            <div class="d-flex align-items-center ms-auto">
                <div class="input-group me-3 d-none d-lg-flex">
                    <input type="text" class="form-control" placeholder="Search..." aria-label="Search">
                    <button class="btn btn-outline-secondary" type="button" aria-label="Search">
                        <i class="bi bi-search"></i>
                    </button>
                </div> 
                <div class="dropdown me-3">
                    <a href="#" class="position-relative text-dark" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Notifications">
                        <i class="bi bi-bell fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            5
                            <span class="visually-hidden">unread notifications</span>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="notificationDropdown">
                        <li class="dropdown-header bg-light py-2 px-3">
                            <h6 class="m-0">Notifications (5)</h6>
                        </li>
                        <li><hr class="dropdown-divider m-0"></li>
                        <li>
                            <a class="dropdown-item d-flex py-2 px-3" href="#">
                                <div class="me-3 text-success"><i class="bi bi-check-circle-fill"></i></div>
                                <div>
                                    <div class="small">New booking confirmed</div>
                                    <small class="text-muted">2 min ago</small>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex py-2 px-3" href="#">
                                <div class="me-3 text-warning"><i class="bi bi-exclamation-triangle-fill"></i></div>
                                <div>
                                    <div class="small">Room 205 checkout delayed</div>
                                    <small class="text-muted">30 min ago</small>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex py-2 px-3" href="#">
                                <div class="me-3 text-primary"><i class="bi bi-info-circle-fill"></i></div>
                                <div>
                                    <div class="small">New guest review received</div>
                                    <small class="text-muted">1 hour ago</small>
                                </div>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider m-0"></li>
                        <li class="dropdown-footer text-center py-2">
                            <a href="#" class="text-primary">View all notifications</a>
                        </li>
                    </ul>
                </div>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle text-decoration-none" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" aria-label="User menu">
                        <img src="https://via.placeholder.com/35" alt="Admin" class="rounded-circle" width="35" height="35">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i> Settings</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-envelope me-2"></i> Messages <span class="badge bg-primary float-end">3</span></a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="../Guest&Public_Pages/home.php"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                    </ul>
                </div>
                 <a class="nav-link" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
                        <i class="fas fa-bars"></i>
                     </a>
            </div>
        </div>
    </nav>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasMenuLabel">Royal Star Resort</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body offcanvas-menu">
            <nav class="nav flex-column">
                <a class="nav-link active" href="../Admin&Staff_Panel/admin.php"><i class="fas fa-home"></i> Home</a>
                <a class="nav-link" href="../Admin&Staff_Panel/content_mang.php"><i class="fas fa-tachometer-alt"></i> Content Management</a>
                <a class="nav-link" href="../Admin&Staff_Panel/room_mang.php"><i class="fas fa-bed"></i> Rooms Management</a>
                <a class="nav-link" href="../Admin&Staff_Panel/program_mang.php"><i class="fas fa-gift"></i> Programs Management</a>
                <a class="nav-link" href="../Admin&Staff_Panel/guest_mang.php"><i class="fas fa-swimming-pool"></i> Guest Management</a>
                <a class="nav-link" href="../Admin&Staff_Panel/employee_mang.php"><i class="fas fa-camera"></i> Staff Management</a>
                <a class="nav-link" href="../Admin&Staff_Panel/salary_mang.php"><i class="fas fa-building"></i> Salary Management</a>
                <a class="nav-link" href="../Admin&Staff_Panel/leave_mang.php"><i class="fas fa-book"></i> Leave Management</a>
                <a class="nav-link" href="../Admin&Staff_Panel/task_mang.php"><i class="fas fa-list-check"></i> Task Management</a>
                
                <div class="mt-4 pt-3 border-top">
                    <a href="../Guest&Public_Pages/home.php" class="btn btn-outline-danger w-100"><i class="fas fa-sign-out-alt me-2"></i> Log Out</a>
                </div>
            </nav>
        </div>
    </div>

    <div class="main-content" id="mainContent">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="dashboard">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="section-title">Dashboard Overview</h3>
                    <div class="d-flex">
                        
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="card quick-action-card" onclick="location.href='../Guest&Public_Pages/room.php';">
                            <div class="quick-action-icon"><i class="bi bi-plus-lg"></i></div>
                            <h5>New Booking</h5>
                            <p class="text-muted small">Create a new reservation</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card quick-action-card" onclick="location.href='../Admin&Staff_Panel/room_mang.php';">
                            <div class="quick-action-icon"><i class="bi bi-house-add"></i></div>
                            <h5>Add Room</h5>
                            <p class="text-muted small">Add new room to inventory</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card quick-action-card" onclick="location.href='../Admin&Staff_Panel/employee_mang.php';">
                            <div class="quick-action-icon"><i class="bi bi-check2-circle"></i></div>
                            <h5>Add New Employee</h5>
                            <p class="text-muted small">Manage tasks</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card quick-action-card" onclick="location.href='../Admin&Staff_Panel/report_mang.php';">
                            <div class="quick-action-icon"><i class="bi bi-file-earmark-bar-graph"></i></div>
                            <h5>Generate Report</h5>
                            <p class="text-muted small">Create custom reports</p>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="card stat-card">
                            <i class="bi bi-house-door stat-icon"></i>
                            <div class="stat-number" id="availableRoomsStat">0</div>
                            <div class="stat-title">Available Rooms</div>
                            <div class="stat-change up"><i class="bi bi-arrow-up"></i> 12% from last month</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card stat-card">
                            <i class="bi bi-calendar-check stat-icon"></i>
                            <div class="stat-number" id="currentBookingsStat">0</div>
                            <div class="stat-title">Current Bookings</div>
                            <div class="stat-change up"><i class="bi bi-arrow-up"></i> 8% from last month</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card stat-card">
                            <i class="bi bi-door-open stat-icon"></i>
                            <div class="stat-number" id="checkoutsTodayStat">0</div>
                            <div class="stat-title">Checkouts Today</div>
                            <div class="stat-change down"><i class="bi bi-arrow-down"></i> 3% from yesterday</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card stat-card">
                            <i class="bi bi-x-circle stat-icon"></i>
                            <div class="stat-number" id="cancellationsStat">0</div>
                            <div class="stat-title">Cancellations</div>
                            <div class="stat-change down"><i class="bi bi-arrow-down"></i> 2% from last month</div>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-lg-8">
                        <div class="card chart-container">
                            <div class="chart-header">
                                <h5 class="chart-title">Monthly Revenue Trend</h5>
                                <select class="form-select form-select-sm" aria-label="Chart range">
                                    <option>This Week</option>
                                    <option>This Month</option>
                                    <option selected>This Year</option>
                                    <option>Custom Range</option>
                                </select>
                            </div>
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card chart-container">
                            <div class="chart-header">
                                <h5 class="chart-title">Booking Sources Distribution</h5>
                            </div>
                            <canvas id="bookingSourceChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="d-flex justify-content-between align-items-center p-3">
                                <h5 class="chart-title">Recent Bookings</h5>
                                <a href="#bookings" class="btn btn-primary btn-sm">View All</a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Booking ID</th>
                                            <th>Guest</th>
                                            <th>Room/Program</th>
                                            <th>Check-In</th>
                                            <th>Check-Out</th>
                                        </tr>
                                    </thead>
                                    <tbody id="recentBookingsTableBody">
                                        <tr>
                                            <td colspan="5" class="text-center">Loading recent bookings...</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card calendar-widget">
                            <div class="calendar-header">
                                <h5 class="calendar-title">Loading...</h5>
                                <div>
                                    <button class="btn btn-sm btn-outline-secondary" aria-label="Previous month"><i class="bi bi-chevron-left"></i></button>
                                    <button class="btn btn-sm btn-outline-secondary" aria-label="Next month"><i class="bi bi-chevron-right"></i></button>
                                </div>
                            </div>
                            <div class="calendar-grid mb-3">
                                <div class="calendar-day-header">Sun</div>
                                <div class="calendar-day-header">Mon</div>
                                <div class="calendar-day-header">Tue</div>
                                <div class="calendar-day-header">Wed</div>
                                <div class="calendar-day-header">Thu</div>
                                <div class="calendar-day-header">Fri</div>
                                <div class="calendar-day-header">Sat</div>
                            </div>
                            <div class="calendar-grid">
                                <div class="calendar-day other-month">25</div>
                                <div class="calendar-day other-month">26</div>
                                <div class="calendar-day other-month">27</div>
                                <div class="calendar-day other-month">28</div>
                                <div class="calendar-day other-month">29</div>
                                <div class="calendar-day other-month">30</div>
                                <div class="calendar-day">1</div>
                                <div class="calendar-day">2</div>
                                <div class="calendar-day">3</div>
                                <div class="calendar-day">4</div>
                                <div class="calendar-day">5</div>
                                <div class="calendar-day">6</div>
                                <div class="calendar-day">7</div>
                                <div class="calendar-day">8</div>
                                <div class="calendar-day">9</div>
                                <div class="calendar-day">10</div>
                                <div class="calendar-day">11</div>
                                <div class="calendar-day">12</div>
                                <div class="calendar-day">13</div> <div class="calendar-day has-booking">14</div>
                                <div class="calendar-day has-booking">15</div>
                                <div class="calendar-day">16</div>
                                <div class="calendar-day">17</div>
                                <div class="calendar-day">18</div>
                                <div class="calendar-day">19</div>
                                <div class="calendar-day">20</div>
                                <div class="calendar-day">21</div>
                                <div class="calendar-day">22</div>
                                <div class="calendar-day">23</div>
                                <div class="calendar-day">24</div>
                                <div class="calendar-day">25</div>
                                <div class="calendar-day">26</div>
                                <div class="calendar-day">27</div>
                                <div class="calendar-day">28</div>
                                <div class="calendar-day">29</div>
                                <div class="calendar-day">30</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="rooms"><h3 class="section-title">Rooms Management</h3></div>
            <div class="tab-pane fade" id="bookings"><h3 class="section-title">Bookings</h3></div>
            <div class="tab-pane fade" id="packages"><h3 class="section-title">Program Management</h3></div>
            <div class="tab-pane fade" id="guests"><h3 class="section-title">Guest Management</h3></div>
            <div class="tab-pane fade" id="reports"><h3 class="section-title">Reports & Analytics</h3></div>
            <div class="tab-pane fade" id="staff"><h3 class="section-title">Staff Management</h3></div>
            <div class="tab-pane fade" id="staff"><h3 class="section-title">Leave Management</h3></div>
            <div class="tab-pane fade" id="salary"><h3 class="section-title">Salary Management</h3></div>
            <div class="tab-pane fade" id="settings"><h3 class="section-title">System Settings</h3></div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Define chart variables in a wider scope
        let revenueChart;
        let bookingSourceChart;

        // --- CHART INITIALIZATION ---
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Initialize Monthly Revenue Trend Chart (Line Chart)
            // This chart now uses HARDCODED data as per your request.
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            revenueChart = new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Revenue (₹)',
                        // Using the hardcoded data from your original file
                        data: [115000, 117000, 119000, 211000, 123000, 126000, 219000, 127000, 125000, 228000, 331000, 334000], 
                        backgroundColor: 'rgba(139, 69, 19, 0.2)',
                        borderColor: 'rgba(139, 69, 19, 1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: 'rgba(139, 69, 19, 1)',
                        pointRadius: 3,
                        pointHoverRadius: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: { duration: 0 },
                    plugins: {
                        legend: { display: true, position: 'top' },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `₹${context.raw.toLocaleString()}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return `₹${value / 1000}k`;
                                }
                            }
                        }
                    }
                }
            });

            // 2. Initialize Booking Sources Distribution Chart (Bar Chart)
            // This also remains hardcoded as your database does not have a 'source' column.
            const bookingSourceCtx = document.getElementById('bookingSourceChart').getContext('2d');
            bookingSourceChart = new Chart(bookingSourceCtx, {
                type: 'bar',
                data: {
                    labels: ['Website', 'OTA', 'Agent', 'Corporate', 'Walk-in'],
                    datasets: [{
                        label: 'Bookings',
                        data: [32, 18, 14, 9, 22], // Hardcoded data
                        backgroundColor: 'rgba(139, 69, 19, 0.8)',
                        borderColor: 'rgba(139, 69, 19, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: { duration: 0 },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.label}: ${context.raw} bookings`;
                                }
                            }
                        }
                    },
                    scales: { y: { beginAtZero: true, ticks: { stepSize: 10 } } }
                }
            });
            
            // 3. Set Calendar to Live Date
            updateCalendarDate();

            // 4. Load all OTHER dynamic data from the server
            loadDashboardData();
        });

        // --- DYNAMIC CALENDAR DATE ---
        function updateCalendarDate() {
            const today = new Date();
            const monthName = today.toLocaleString('default', { month: 'long' });
            const year = today.getFullYear();
            const day = today.getDate();

            // Update calendar title
            const calendarTitle = document.querySelector('.calendar-title');
            if (calendarTitle) {
                calendarTitle.textContent = `${monthName} ${year}`;
            }
            
            // Remove 'active' from the hardcoded day (13)
            const oldActiveDay = document.querySelector('.calendar-day.active');
            if (oldActiveDay) {
                oldActiveDay.classList.remove('active');
            }

            // Find and highlight the current day
            const allDays = document.querySelectorAll('.calendar-grid .calendar-day:not(.other-month)');
            allDays.forEach(dayElement => {
                if (parseInt(dayElement.textContent) === day) {
                    dayElement.classList.add('active');
                }
            });
        }

        // --- AJAX DATA FETCHING ---
        function loadDashboardData() {
            const apiURL = '../Admin&Staff_APIs/fetch_admin_data.php';

            // Fetch Stats (Dynamic)
            fetch(`${apiURL}?query=stats`)
                .then(res => res.json()).then(data => {
                    if (data.error) throw new Error(data.error);
                    document.getElementById('availableRoomsStat').textContent = data.available_rooms;
                    document.getElementById('currentBookingsStat').textContent = data.current_bookings;
                    document.getElementById('checkoutsTodayStat').textContent = data.checkouts_today;
                    document.getElementById('cancellationsStat').textContent = data.cancellations;
                }).catch(err => console.error('Error fetching stats:', err));

            // NOTE: The fetch for 'revenue_trend' has been REMOVED as requested.

            // Fetch Recent Bookings for Table (Dynamic)
            fetch(`${apiURL}?query=recent_bookings`)
                .then(res => res.json()).then(data => {
                    if (data.error) throw new Error(data.error);
                    const tbody = document.getElementById('recentBookingsTableBody');
                    tbody.innerHTML = ''; // Clear the "Loading..." message
                    if (data.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="5" class="text-center">No recent bookings found.</td></tr>';
                        return;
                    }
                    data.forEach(b => {
                        // Format dates
                        const checkIn = new Date(b.check_in).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
                        const checkOut = new Date(b.check_out).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });

                        tbody.innerHTML += `<tr>
                            <td>#RS-${b.booking_id}</td>
                            <td>${b.guest_name}</td>
                            <td>${b.item_name || 'N/A'}</td> 
                            <td>${checkIn}</td>
                            <td>${checkOut}</td>
                        </tr>`;
                    });
                }).catch(err => {
                    console.error('Error fetching recent bookings:', err)
                    const tbody = document.getElementById('recentBookingsTableBody');
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center text-danger">Error loading bookings.</td></tr>';
                });
            
            // NOTE: We do not fetch 'booking_sources' as the data column is missing in the SQL file.
        }
    </script>
</body>
</html>