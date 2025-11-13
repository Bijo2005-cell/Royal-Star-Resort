<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../Guest&Public/login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Leave Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../Styling&Scripts/style1.css">
</head>
<body>
<nav class="navbar navbar-expand navbar-dark">
    <div class="container-fluid"><a class="navbar-brand" href="../Admin&Staff_Panel/admin.php">Royal <span>Star</span> Resort</a></div>
</nav>
<main class="container my-4">
    <header class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 page-title">Leave Management</h1>
    </header>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Type</th>
                            <th>Dates</th>
                            <th>Days</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="leaveTableBody">
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.getElementById('leaveTableBody');

    const fetchAllLeaveRequests = () => {
        tableBody.innerHTML = '<tr><td colspan="7" class="text-center">Loading...</td></tr>';
        // FIX: This now calls the correct API file.
        fetch('../Admin&Staff_APIs/api_leave_admin.php?action=fetch_all_leaves')
            .then(res => res.json())
            .then(data => {
                renderTable(data);
            })
            .catch(err => {
                tableBody.innerHTML = '<tr><td colspan="7" class="text-center text-danger">Failed to load data.</td></tr>';
                console.error(err);
            });
    };

    const renderTable = (requests) => {
        tableBody.innerHTML = '';
        if (requests.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="7" class="text-center">No leave requests found.</td></tr>';
            return;
        }
        requests.forEach(req => {
            const start = new Date(req.start_date);
            const end = new Date(req.end_date);
            const days = Math.ceil((end - start) / (1000 * 60 * 60 * 24)) + 1;
            
            let statusBadge = '';
            let actionButtons = '';

            if (req.status === 'Pending') {
                statusBadge = `<span class="badge bg-warning text-dark">Pending</span>`;
                actionButtons = `
                    <button class="btn btn-sm btn-success" onclick="updateStatus(${req.id}, 'Approved')" title="Approve"><i class="bi bi-check-lg"></i></button>
                    <button class="btn btn-sm btn-danger" onclick="updateStatus(${req.id}, 'Rejected')" title="Reject"><i class="bi bi-x-lg"></i></button>
                `;
            } else if (req.status === 'Approved') {
                statusBadge = `<span class="badge bg-success">Approved</span>`;
            } else {
                statusBadge = `<span class="badge bg-danger">Rejected</span>`;
            }

            const row = `
                <tr>
                    <td>${req.username}</td>
                    <td>${req.leave_type}</td>
                    <td>${start.toLocaleDateString()} - ${end.toLocaleDateString()}</td>
                    <td>${days}</td>
                    <td><span class="d-inline-block text-truncate" style="max-width: 150px;">${req.reason}</span></td>
                    <td>${statusBadge}</td>
                    <td class="text-center">${actionButtons}</td>
                </tr>
            `;
            tableBody.insertAdjacentHTML('beforeend', row);
        });
    };
    
    window.updateStatus = (id, status) => {
        if (!confirm(`Are you sure you want to ${status.toLowerCase()} this request?`)) return;

        // FIX: This now calls the correct API file.
        fetch('../Admin&Staff_APIs/api_leave_admin.php?action=update_status', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ id: id, status: status })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                fetchAllLeaveRequests(); // Refresh the table
            } else {
                alert('Failed to update status: ' + (data.message || 'Unknown error'));
            }
        });
    };

    // Initial load
    fetchAllLeaveRequests();
});
</script>
</body>
</html>