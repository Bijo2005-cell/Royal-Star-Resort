<?php
session_start();
// Database connection
include '../Database/db_connect.php'; // We will create this file in the next step

// Security check - ensure user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../Guest&Public_Pages/login.php');
    exit();
}

// Fetch all staff members for the dropdown
$staff_sql = "SELECT id, username FROM users WHERE role = 'staff'";
$staff_result = $conn->query($staff_sql);
$staff_members = $staff_result->fetch_all(MYSQLI_ASSOC);

// Fetch all tasks to display in the list
$tasks_sql = "SELECT t.*, u.username 
              FROM tasks t
              JOIN users u ON t.assigned_to_user_id = u.id
              ORDER BY t.status ASC, t.due_date DESC";
$tasks_result = $conn->query($tasks_sql);
$tasks = $tasks_result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Task Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Styling&Scripts/style.css">
    <style>
        .main-content { padding: 30px; }
        .card { margin-bottom: 20px; }
        .status-Pending { color: #ffc107; }
        .status-Completed { color: #198754; }
    </style>
</head>
<body>
    <div class="main-content">
        <h2 class="mb-4">Task Management</h2>

        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <span><i class="fas fa-plus"></i> Add New Task</span>
                    </div>
                    <div class="card-body">
                        
                        <form action="../Admin&Staff_APIs/api_add_task.php" method="POST">
                        
                            <div class="mb-3">
                                <label for="user_id" class="form-label">Assign To:</label>
                                <select class="form-select" id="user_id" name="user_id" required>
                                    <option value="">Select Staff Member</option>
                                    <?php foreach ($staff_members as $staff): ?>
                                        <option value="<?php echo $staff['id']; ?>">
                                            <?php echo htmlspecialchars($staff['username']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Task Title:</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description:</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="priority" class="form-label">Priority:</label>
                                    <select class="form-select" id="priority" name="priority">
                                        <option value="Low">Low</option>
                                        <option value="Medium" selected>Medium</option>
                                        <option value="High">High</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="due_date" class="form-label">Due Date:</label>
                                    <input type="datetime-local" class="form-control" id="due_date" name="due_date">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-gold w-100">Assign Task</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <span><i class="fas fa-list-check"></i> All Tasks</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Task</th>
                                        <th>Assigned To</th>
                                        <th>Priority</th>
                                        <th>Due Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($tasks)): ?>
                                        <tr>
                                            <td colspan="5" class="text-center">No tasks found.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($tasks as $task): ?>
                                            <tr>
                                                <td>
                                                    <strong class="status-<?php echo $task['status']; ?>">
                                                        <?php echo $task['status']; ?>
                                                    </strong>
                                                </td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($task['title']); ?></strong>
                                                    <p class="small text-muted mb-0"><?php echo htmlspecialchars($task['description']); ?></p>
                                                </td>
                                                <td><?php echo htmlspecialchars($task['username']); ?></td>
                                                <td><?php echo htmlspecialchars($task['priority']); ?></td>
                                                <td><?php echo $task['due_date'] ? date('M d, Y g:i A', strtotime($task['due_date'])) : 'N/A'; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>