<?php
header('Content-Type: application/json');
include '../Database/db_connect.php'; 

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

// --- FIX: Added 'update' case ---
switch ($action) {
    case 'fetch':
        fetch_staff($conn);
        break;
    case 'add':
        add_staff($conn);
        break;
    case 'update':
        update_staff($conn);
        break;
    case 'delete':
        delete_staff($conn);
        break;
    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action specified.']);
}

function delete_staff($conn) {
    $user_id = (int)$_POST['id'];
    
    // We must delete from salary_records first due to foreign key constraints
    $conn->begin_transaction();
    try {
        $stmt_salary = $conn->prepare("DELETE FROM salary_records WHERE user_id = ?");
        $stmt_salary->bind_param("i", $user_id);
        $stmt_salary->execute();
        $stmt_salary->close();

        $stmt_user = $conn->prepare("DELETE FROM users WHERE id = ? AND role = 'staff'");
        $stmt_user->bind_param("i", $user_id);
        $stmt_user->execute();
        
        if ($stmt_user->affected_rows > 0) {
            $conn->commit();
            echo json_encode(['status' => 'success', 'message' => 'Staff member deleted successfully!']);
        } else {
            throw new Exception('Staff member not found or is not a staff role.');
        }
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete staff member: ' . $e->getMessage()]);
    }
    $stmt_user->close();
}

function add_staff($conn) {
    $conn->begin_transaction();
    try {
        // 1. Insert into users table
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, mobile_number, role, department) VALUES (?, ?, ?, ?, 'staff', ?)");
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $position = $_POST['position'];
        $department = getDepartment($position);
        $hashed_password = password_hash('password123', PASSWORD_DEFAULT); // Default password
        
        $stmt->bind_param("sssss", $name, $email, $hashed_password, $phone, $department);
        $stmt->execute();
        $user_id = $conn->insert_id;
        if ($user_id == 0) throw new Exception("Failed to create user record.");
        $stmt->close();

        // 2. Insert into salary_records table
        // Use CURDATE() for payment_date to ensure it's the latest record
        $stmt = $conn->prepare("INSERT INTO salary_records (user_id, job_title, hire_date, basic_salary, payment_date) VALUES (?, ?, ?, ?, CURDATE())");
        $hire_date = $_POST['hire_date'];
        $basic_salary = 30000.00; // Default salary
        $stmt->bind_param("issd", $user_id, $position, $hire_date, $basic_salary);
        $stmt->execute();
        $stmt->close();

        $conn->commit();
        echo json_encode(['status' => 'success', 'message' => 'Staff member added successfully!']);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
}

// --- NEW: Added update_staff function ---
function update_staff($conn) {
    $conn->begin_transaction();
    try {
        $id = (int)$_POST['id'];
        
        // 1. Update users table
        $stmt_user = $conn->prepare("UPDATE users SET username = ?, email = ?, mobile_number = ?, department = ? WHERE id = ?");
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $position = $_POST['position'];
        $department = getDepartment($position);
        
        $stmt_user->bind_param("ssssi", $name, $email, $phone, $department, $id);
        $stmt_user->execute();
        $stmt_user->close();

        // 2. Find the latest salary_id for this user
        $stmt_find = $conn->prepare("SELECT MAX(salary_id) as max_id FROM salary_records WHERE user_id = ?");
        $stmt_find->bind_param("i", $id);
        $stmt_find->execute();
        $result = $stmt_find->get_result();
        $max_id = $result->fetch_assoc()['max_id'];
        $stmt_find->close();

        if ($max_id) {
            // 3. Update the latest salary record
            $stmt_update = $conn->prepare("UPDATE salary_records SET job_title = ?, hire_date = ? WHERE salary_id = ?");
            $hire_date = $_POST['hire_date'];
            $stmt_update->bind_param("ssi", $position, $hire_date, $max_id);
            $stmt_update->execute();
            $stmt_update->close();
        } else {
             // Fallback: If no salary record exists, create one.
            $stmt_insert = $conn->prepare("INSERT INTO salary_records (user_id, job_title, hire_date, basic_salary, payment_date) VALUES (?, ?, ?, 30000.00, CURDATE())");
            $hire_date = $_POST['hire_date'];
            $stmt_insert->bind_param("iss", $id, $position, $hire_date);
            $stmt_insert->execute();
            $stmt_insert->close();
        }

        $conn->commit();
        echo json_encode(['status' => 'success', 'message' => 'Staff member updated successfully!']);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
}

function fetch_staff($conn) {
    // --- FIX: Robust query using MAX(salary_id) and includes search/filter ---
    $sql = "SELECT 
                u.id as id, 
                u.username as name, 
                u.email, 
                u.mobile_number as phone, 
                sr.job_title as position, 
                sr.hire_date,
                u.department
            FROM users u
            JOIN (
                -- Finds the most recent salary_records *entry* for each user
                SELECT user_id, MAX(salary_id) AS max_id 
                FROM salary_records 
                GROUP BY user_id
            ) latest_sr ON u.id = latest_sr.user_id
            JOIN salary_records sr ON u.id = sr.user_id AND sr.salary_id = latest_sr.max_id
            WHERE u.role = 'staff'";

    $params = [];
    $types = "";

    // Add search logic
    if (!empty($_GET['search'])) {
        $search = '%' . $_GET['search'] . '%';
        $sql .= " AND (u.username LIKE ? OR sr.job_title LIKE ?)";
        array_push($params, $search, $search);
        $types .= "ss";
    }

    // Add filter logic
    if (!empty($_GET['filter']) && $_GET['filter'] != 'all') {
        $filter = $_GET['filter'];
        $sql .= " AND sr.job_title = ?";
        array_push($params, $filter);
        $types .= "s";
    }

    $sql .= " ORDER BY u.username ASC";
    
    $stmt = $conn->prepare($sql);
    if (!empty($params)) {
        // Need to use bind_param with array_merge for dynamic params
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    $staff = [];
    while($row = $result->fetch_assoc()) {
        $row['department'] = $row['department'] ? $row['department'] : getDepartment($row['position']);
        // The 'status' (Active, On Leave) isn't in the DB, so we'll default to 'Active'
        $row['status'] = 'Active'; 
        $staff[] = $row;
    }
    echo json_encode($staff);
    $stmt->close();
}

function getDepartment($position) {
    switch($position) {
        case 'Manager': 
        case 'General Manager':
            return 'Management';
        case 'Receptionist': return 'Front Office';
        case 'Head Chef': 
        case 'Chef':
        case 'Waiter': 
            return 'Food & Beverage';
        case 'Housekeeping': return 'Housekeeping';
        case 'Maintenance': return 'Facilities';
        default: return 'General';
    }
}

$conn->close();
?>