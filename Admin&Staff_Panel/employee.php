<?php
session_start();

// Security check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header('Location: ../Guest&Public_Pages/login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Royal Star Resort - Employee Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Styling&Scripts/style.css">
</head>
<body>
    <nav class="navbar navbar-expand navbar-dark ">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Royal <span>Star</span> Resort</a>
            <div class="d-flex align-items-center ms-auto">
                <div class="input-group me-3 d-none d-lg-flex">
                    <input type="text" class="form-control" placeholder="Search..." aria-label="Search">
                    <button class="btn btn-outline-secondary" type="button" aria-label="Search">
                        <i class="fas fa-search"></i>
                    </button>
                </div> 
            
        
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link notification-bell" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">5</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
                        <li>
                            <h6 class="dropdown-header">Notifications (3)</h6>
                        </li>
                       
                        <li>
                            <div class="notification-item unread">
                                <div class="d-flex align-items-center">
                                    <div class="notification-icon">
                                        <i class="fas fa-tasks"></i>
                                    </div>
                                    <div class="notification-content">
                                        <div class="notification-title">New Task Assigned</div>
                                        <div class="notification-text">Prepare VIP welcome package for Room 301</div>
                                    </div>
                                    <div class="notification-time">1 hour ago</div>
                                </div>
                            </div>
                        </li>
                       
                        <li>
                            <div class="notification-item unread">
                                <div class="d-flex align-items-center">
                                    <div class="notification-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="notification-content">
                                        <div class="notification-title">Leave Approved</div>
                                        <div class="notification-text">Your leave request has been approved</div>
                                    </div>
                                    <div class="notification-time">1 day ago</div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="notification-item">
                                <div class="d-flex align-items-center">
                                    <div class="notification-icon">
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div class="notification-content">
                                        <div class="notification-title">Performance Bonus</div>
                                        <div class="notification-text">You earned a bonus for excellent guest feedback</div>
                                    </div>
                                    <div class="notification-time">3 days ago</div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-center" href="#">View all notifications</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="messagesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-envelope"></i>
                        <span class="notification-badge">2</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="messagesDropdown">
                        <li>
                            <h6 class="dropdown-header">Messages (2)</h6>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="message-preview unread">
                                    <img src="" class="message-avatar" alt="Albin">
                                    <div class="message-content">
                                        <div class="message-sender">Albin</div>
                                        <div class="message-text">About the VIP arrival tomorrow, can we arrange early check-in?</div>
                                    </div>
                                    <div class="message-time">30 min ago</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="message-preview unread">
                                    <img src="" class="message-avatar" alt="Jithin">
                                    <div class="message-content">
                                        <div class="message-sender">Jithin</div>
                                        <div class="message-text">The monthly report needs some adjustments before submission</div>
                                    </div>
                                    <div class="message-time">2 hours ago</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="message-preview">
                                    <img src="" class="message-avatar" alt="David Wilson">
                                    <div class="message-content">
                                        <div class="message-sender">Vishnu</div>
                                        <div class="message-text">Great job with the Wellington account!</div>
                                    </div>
                                    <div class="message-time">1 day ago</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-center" href="#">View all messages</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <h6 class="dropdown-header">Signed in as <strong id="signedInAsName"></strong></h6>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="salary.php"><i class="fas fa-file-invoice-dollar me-2"></i> Payroll</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="../Guest&Public_Pages/home.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
             <a class="nav-link" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
                    <i class="fas fa-bars"></i>
                  </a>
        </div>
    </nav>
    
   
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasMenuLabel">Royal Star Resort</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
                <img src="" alt="User Avatar">
                <h5 id="offcanvasName">Loading...</h5>
                <p id="offcanvasRole">Loading...</p>
             <div class="offcanvas-body offcanvas-menu">
            <nav class="nav flex-column">
                <a class="nav-link active" href="employee.php"><i class="fas fa-home"></i>Dashboard</a>
                <a class="nav-link" href="employee_mang.php"><i class="fas fa-users"></i> <span>Employee Management</span></a>
                <a class="nav-link" href="room_mang.php"><i class="fas fa-bed"></i> <span>Rooms Management</span></a>
                <a class="nav-link" href="leave_request.php"><i class="fas fa-plane"></i> <span>Leave Requests</span></a>
                <a class="nav-link" href="salary.php"><i class="fas fa-chart-line"></i> <span>Salary</span></a>
                <a class="nav-link" href="rules.php"><i class="fas fa-cog"></i> <span>Rules</span></a>
                <a class="nav-link" href="#"><i class="fas fa-clipboard-list"></i> Settings</a>
                <div class="mt-4 pt-3 border-top">
                    <a href="../Guest&Public_Pages/home.php" class="btn btn-outline-danger w-100"><i class="fas fa-sign-out-alt me-2"></i> Log Out</a>
                </div>
            </nav>
        </div>
        </div>
   
        <div class="main-content" id="mainContent">
            <div class="welcome-message animate__animated animate__fadeIn">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h2 id="welcomeName">Welcome back!</h2>
                        <p id="welcomeSubtitle">Loading dashboard data...</p>
                    </div>
                    <div class="d-flex flex-column align-items-end">
                        <div class="mb-3">
                            <div class="stat-value">85%</div>
                            <div class="stat-label">Occupancy Rate</div>
                        </div>
                        <div class="progress w-100">
                            <div class="progress-bar" role="progressbar" style="width: 85%;" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-lg-6">
                    <div class="card animate__animated animate__fadeInUp">
                        <div class="card-header">
                            <span><i class="fas fa-tasks"></i> Today's Tasks</span>
                            <a href="#" class="btn btn-gold btn-sm">View All</a>
                        </div>
                        <div class="card-body" id="tasksContainer">
                            </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card animate__animated animate__fadeInUp animate-delay-1">
                        <div class="card-header">
                            <span><i class="fas fa-users"></i> Guest Status</span>
                            <a href="#" class="btn btn-gold btn-sm">Manage Guests</a>
                        </div>
                        <div class="card-body" id="guestStatusContainer">
                            </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-lg-4">
                    <div class="row g-4">
                        <div class="col-md-6 col-lg-12">
                            <div class="weather-card animate__animated animate__fadeInUp animate-delay-2">
                                <div class="weather-icon">
                                    <i class="fas fa-sun"></i>
                                </div>
                                <div class="weather-temp">32°C</div>
                                <div class="weather-desc">Sunny • Feels like 35°C</div>
                                <div class="weather-details">
                                    <div class="weather-detail">
                                        <i class="fas fa-tint"></i>
                                        <span>Humidity: 65%</span>
                                    </div>
                                    <div class="weather-detail">
                                        <i class="fas fa-wind"></i>
                                        <span>Wind: 12 km/h</span>
                                    </div>
                                    <div class="weather-detail">
                                        <i class="fas fa-cloud-rain"></i>
                                        <span>Rain: 10%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-12">
                            <div class="time-tracking animate__animated animate__fadeInUp animate-delay-3">
                                <div class="time-display" id="liveTimeDisplay">08:45 AM</div>
                                <div class="time-status">Currently On Shift</div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="time-actions">
                                    <button class="btn btn-outline-gold btn-sm"><i class="fas fa-coffee"></i> Break</button>
                                    <button class="btn btn-gold btn-sm"><i class="fas fa-sign-out-alt"></i> End Shift</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card animate__animated animate__fadeInUp animate-delay-2">
                        <div class="card-header">
                            <span><i class="fas fa-history"></i> Recent Activity</span>
                            <a href="#" class="btn btn-gold btn-sm">View All</a>
                        </div>
                        <div class="card-body">
                            <ul class="recent-activity" id="activityLogContainer">
                                </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card animate__animated animate__fadeInUp animate-delay-3">
                        <div class="card-header">
                            <span><i class="fas fa-chart-pie"></i> Department Stats</span>
                            <a href="#" class="btn btn-gold btn-sm">View Report</a>
                        </div>
                        <div class="card-body">
                            <div class="department-stats">
                                <div class="department-stat">
                                    <h5>12</h5>
                                    <p>Staff On Duty</p>
                                    <i class="fas fa-user-clock stat-icon"></i>
                                </div>
                                <div class="department-stat">
                                    <h5>8</h5>
                                    <p>Pending Tasks</p>
                                    <i class="fas fa-tasks stat-icon"></i>
                                </div>
                                
                                <div class="department-stat">
                                    <h5>95%</h5>
                                    <p>Guest Satisfaction</p>
                                    <i class="fas fa-star stat-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card animate__animated animate__fadeInUp animate-delay-4">
                        <div class="card-header">
                            <span><i class="fas fa-bed"></i> Room Status</span>
                            <a href="room_mang.php" class="btn btn-gold btn-sm">View All</a>
                        </div>
                        <div class="card-body">
                            <div class="room-status">
                                <div class="room-number">205</div>
                                <div class="room-info">
                                    <div class="room-type">Deluxe Suite</div>
                                    <div class="room-desc">Occupied by John Smith • Check-out: 06/15</div>
                                </div>
                                <span class="room-status-badge status-occupied">Occupied</span>
                            </div>
                            <div class="room-status">
                                <div class="room-number">108</div>
                                <div class="room-info">
                                    <div class="room-type">Standard Room</div>
                                    <div class="room-desc">Reserved for Emily Davis • Check-in: Tomorrow</div>
                                </div>
                                <span class="room-status-badge status-available">Available</span>
                            </div>
                            <div class="room-status">
                                <div class="room-number">301</div>
                                <div class="room-info">
                                    <div class="room-type">Presidential Suite</div>
                                    <div class="room-desc">VIP arrival today • Needs preparation</div>
                                </div>
                                <span class="room-status-badge status-maintenance">Preparation</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../Styling&Scripts/script.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // --- LIVE TIME FUNCTION ---
    function updateLiveTime() {
        const timeDisplay = document.getElementById('liveTimeDisplay');
        if (timeDisplay) {
            const now = new Date();
            // Formats to "04:39 PM"
            const timeString = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true });
            timeDisplay.textContent = timeString;
        }
    }
    // Update time immediately on load
    updateLiveTime();
    // Update time every second (1000 milliseconds)
    setInterval(updateLiveTime, 1000);

    
    // --- DATA FETCHING FUNCTIONS ---
    
    const tasksContainer = document.getElementById('tasksContainer');
    const guestStatusContainer = document.getElementById('guestStatusContainer');
    const activityLogContainer = document.getElementById('activityLogContainer');

    // Function to fetch Welcome Stats
    function fetchWelcomeStats() {
        fetch('../Admin&Staff_APIs/fetch_employee_data.php?query=welcome_stats')
            .then(res => res.json())
            .then(data => {
                if (data.error) { console.error(data.error); return; }
                document.getElementById('welcomeSubtitle').textContent = `The resort is currently at ${data.occupancy}% occupancy with ${data.vip_guests} VIP guests arriving today.`;
                const firstName = data.username.split(' ')[0];
                document.getElementById('welcomeName').innerHTML = `Welcome back, ${firstName}!`;
                document.getElementById('offcanvasName').textContent = data.username;
                document.getElementById('signedInAsName').textContent = data.username;
                document.getElementById('offcanvasRole').textContent = data.department || 'Staff';
            })
            .catch(error => console.error('Error fetching welcome data:', error));
    }

    // Function to fetch Tasks
    function fetchTasks() {
        fetch('../Admin&Staff_APIs/fetch_employee_data.php?query=tasks')
            .then(res => res.json())
            .then(data => {
                tasksContainer.innerHTML = ''; 
                if (data.error) { tasksContainer.innerHTML = `<p class="p-3">${data.error}</p>`; return; }
                if (data.length === 0) {
                    tasksContainer.innerHTML = '<p class="p-3">No tasks assigned for today.</p>';
                    return;
                }
                data.forEach(task => {
                    let priorityClass = (task.priority || 'low').toLowerCase();
                    let dueDate = task.due_date ? new Date(task.due_date).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : 'N/A';
                    
                    tasksContainer.innerHTML += `
                        <div class="task-item" data-task-id="${task.task_id}">
                            <input type="checkbox" class="task-checkbox">
                            <div class="task-content">
                                <div class="task-title">${task.title}</div>
                                <div class="task-desc">${task.description}</div>
                                <div class="task-meta">
                                    <span><i class="fas fa-clock"></i> Due: ${dueDate}</span>
                                    <span class="task-priority priority-${priorityClass}">${task.priority} Priority</span>
                                </div>
                            </div>
                        </div>`;
                });
            })
            .catch(error => console.error('Error fetching tasks:', error));
    }

    // Function to fetch Guest Status
    function fetchGuestStatus() {
        fetch('../Admin&Staff_APIs/fetch_employee_data.php?query=guest_status')
            .then(res => res.json())
            .then(data => {
                guestStatusContainer.innerHTML = '';
                 if (data.error) { guestStatusContainer.innerHTML = `<p class_name="p-3">${data.error}</p>`; return; }
                if (data.length === 0) {
                    guestStatusContainer.innerHTML = '<p class="p-3">No recent guest activity.</p>';
                    return;
                }
                data.forEach(guest => {
                    let statusClass = 'reserved';
                    let statusText = 'Reserved';
                    if (guest.status === 'CheckedIn') { statusClass = 'checkedin'; statusText = 'Checked In'; }
                    else if (guest.status === 'CheckedOut') { statusClass = 'checkedout'; statusText = 'Checked Out'; }
                    else if (guest.status === 'Confirmed') { statusClass = 'reserved'; statusText = 'Reserved'; }

                    let description = '';
                    if (guest.room_number) { description = `Room ${guest.room_number} • ${guest.check_in} to ${guest.check_out}`; }
                    else if (guest.program_title) { description = `Program: ${guest.program_title} • ${guest.check_in}`; }
                    else { description = 'No room details'; }

                    guestStatusContainer.innerHTML += `
                        <div class="guest-card">
                            <div class="guest-info">
                                <h6>${guest.guest_name || 'N/A'}</h6>
                                <p>${description}</p>
                            </div>
                            <span class="guest-status status-${statusClass}">${statusText}</span>
                        </div>`;
                });
            })
            .catch(error => console.error('Error fetching guest status:', error));
    }

    // Function to fetch Recent Activity
    function fetchRecentActivity() {
        fetch('../Admin&Staff_APIs/fetch_employee_data.php?query=recent_activity')
            .then(res => res.json())
            .then(data => {
                activityLogContainer.innerHTML = '';
                 if (data.error) { activityLogContainer.innerHTML = `<li>${data.error}</li>`; return; }
                if (data.length === 0) {
                    activityLogContainer.innerHTML = '<li class="p-3">No recent activity.</li>';
                    return;
                }
                data.forEach(activity => {
                    let iconClass = 'fa-check-circle';
                    if (activity.action_title.toLowerCase().includes('task')) { iconClass = 'fa-tasks'; }
                    else if (activity.action_title.toLowerCase().includes('leave')) { iconClass = 'fa-plane'; }
                    else if (activity.action_title.toLowerCase().includes('check-in')) { iconClass = 'fa-user-check'; }
                    else if (activity.action_title.toLowerCase().includes('check-out')) { iconClass = 'fa-user-minus'; }
                    
                    let activityTime = new Date(activity.timestamp).toLocaleString([], { dateStyle: 'short', timeStyle: 'short' });
                    let byUser = activity.username ? ` (by ${activity.username})` : '';

                    activityLogContainer.innerHTML += `
                        <li class="activity-item">
                            <div class="activity-icon"><i class="fas ${iconClass}"></i></div>
                            <div class="activity-content">
                                <div class="activity-title">${activity.action_title}${byUser}</div>
                                <div class="activity-desc">${activity.action_description}</div>
                                <div class="activity-time">${activityTime}</div>
                            </div>
                        </li>`;
                });
            })
            .catch(error => console.error('Error fetching activity log:', error));
    }

    
    // --- INITIAL DATA LOAD ---
    // Fetch all data when the page first loads
    fetchWelcomeStats();
    fetchTasks();
    fetchGuestStatus();
    fetchRecentActivity();

    
    // --- POLLING ---
    // Re-fetch tasks, guests, and activity every 30 seconds (30000 milliseconds)
    // This will make new tasks appear automatically.
    setInterval(function() {
        fetchTasks();
        fetchGuestStatus();
        fetchRecentActivity();
    }, 30000); // 30 seconds


    // --- EVENT LISTENERS (No change needed here) ---
    tasksContainer.addEventListener('change', function(e) {
        if (e.target.classList.contains('task-checkbox')) {
            const taskItem = e.target.closest('.task-item');
            const taskId = taskItem.dataset.taskId;
            const isChecked = e.target.checked;

            // Send update to the server
            fetch('../Admin&Staff_APIs/api_update_task.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    task_id: taskId,
                    status: isChecked // true if checked (Completed), false if unchecked
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && isChecked) {
                    // Remove the task from the list with an animation
                    taskItem.classList.add('animate__animated', 'animate__fadeOut');
                    setTimeout(() => {
                        taskItem.remove();
                        // Check if no tasks are left
                        if (tasksContainer.children.length === 0) {
                            tasksContainer.innerHTML = '<p class="p-3">No tasks assigned for today.</p>';
                        }
                    }, 500);
                } else if (data.error) {
                    console.error(data.error);
                    // uncheck the box if it failed
                    e.target.checked = !isChecked;
                }
            })
            .catch(error => {
                console.error('Error updating task:', error);
                e.target.checked = !isChecked;
            });
        }
    });

});
</script>

</body>
</html>