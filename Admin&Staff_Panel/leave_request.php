<?php
session_start();
// Security check to ensure only logged-in staff or admins can see this page
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['staff', 'admin'])) {
    header('Location: ../Guest&Public_Pages/login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Royal Star Resort - Leave Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../Styling&Scripts/style1.css">
    </head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light mb-5">
            <div class="container">
                 <a class="navbar-brand" >Royal <span>Star</span> Resort</a>
            </div>
        </nav>
    </header>

    <div class="container mb-5">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header"><i class="fas fa-paper-plane me-2"></i>Request Leave</div>
                    <div class="card-body p-4">
                        <form id="leaveRequestForm">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="leaveType" class="form-label">Leave Type</label>
                                    <select class="form-select" id="leaveType" name="leaveType" required>
                                        <option value="" selected disabled>Select leave type</option>
                                        <option value="Vacation">Vacation Leave</option>
                                        <option value="Sick">Sick Leave</option>
                                        <option value="Personal">Personal Leave</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="startDate" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="startDate" name="startDate" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="endDate" class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="endDate" name="endDate" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="reason" class="form-label">Reason for Leave</label>
                                <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
                            </div>
                            
                            <div class="mb-4">
                                <label for="contactInfo" class="form-label">Contact Information During Leave</label>
                                <input type="text" class="form-control" id="contactInfo" name="contactInfo" required>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-check-circle me-2"></i>Submit Request</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header"><i class="fas fa-history me-2"></i>Leave History</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Dates</th>
                                        <th>Days</th>
                                        </tr>
                                </thead>
                                <tbody id="leaveHistoryBody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const leaveRequestForm = document.getElementById('leaveRequestForm');
            const leaveHistoryBody = document.getElementById('leaveHistoryBody');
            const startDateInput = document.getElementById('startDate');
            const endDateInput = document.getElementById('endDate');

            function fetchLeaveHistory() {
                // FIX: Changed colspan to 3 since there are now 3 columns
                leaveHistoryBody.innerHTML = '<tr><td colspan="3" class="text-center">Loading history...</td></tr>';
                fetch('../Admin&Staff_APIs/fetch_leave_history.php')
                    .then(response => response.json())
                    .then(data => {
                        leaveHistoryBody.innerHTML = '';
                        if (data.error) {
                            leaveHistoryBody.innerHTML = `<tr><td colspan="3" class="text-center text-danger">${data.error}</td></tr>`;
                            return;
                        }
                        if (data.length === 0) {
                            leaveHistoryBody.innerHTML = '<tr><td colspan="3" class="text-center">No leave history found.</td></tr>';
                            return;
                        }

                        data.forEach(request => {
                            const startDate = new Date(request.start_date);
                            const endDate = new Date(request.end_date);
                            const days = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;
                            
                            // FIX: Removed the status-related HTML from the table row
                            leaveHistoryBody.innerHTML += `
                                <tr>
                                    <td>${request.leave_type}</td>
                                    <td>${startDate.toLocaleDateString('en-GB', {month: 'short', day: 'numeric'})} - ${endDate.toLocaleDateString('en-GB', {day: 'numeric'})}</td>
                                    <td>${days}</td>
                                </tr>
                            `;
                        });
                    })
                    .catch(error => {
                        console.error('Fetch History Error:', error);
                        leaveHistoryBody.innerHTML = '<tr><td colspan="3" class="text-center text-danger">Could not load history.</td></tr>';
                    });
            }

            leaveRequestForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(leaveRequestForm);
                const start = new Date(startDateInput.value);
                const end = new Date(endDateInput.value);
                if (end < start) {
                    alert('End date must be after start date.');
                    return;
                }
                
                fetch('../Admin&Staff_APIs/submit_leave.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Server error: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    alert(data.message);
                    if (data.success) {
                        leaveRequestForm.reset();
                        fetchLeaveHistory(); // Refresh history table
                    }
                })
                .catch(error => {
                    console.error('Submit Error:', error);
                    alert('A critical error occurred while submitting.');
                });
            });

            // Set minimum date for date pickers to today
            const today = new Date().toISOString().split('T')[0];
            if (startDateInput) startDateInput.min = today;
            if (endDateInput) endDateInput.min = today;
            
            if (startDateInput) {
                startDateInput.addEventListener('change', function() {
                    endDateInput.min = this.value;
                });
            }

            // Initial load of leave history
            fetchLeaveHistory();
        });
    </script>
</body>
</html>