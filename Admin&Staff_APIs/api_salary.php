<?php
header('Content-Type: application/json');
include '../Database/db_connect.php'; 

$action = $_REQUEST['action'] ?? '';

switch ($action) {
    case 'fetch_employees':
        fetch_employees($conn);
        break;
    case 'fetch_monthly_summary':
        fetch_monthly_summary($conn);
        break;
    case 'get_salary_details':
        get_salary_details($conn);
        break;
    case 'fetch_history':
        fetch_history($conn);
        break;
    case 'save_record':
        save_record($conn);
        break;
    case 'delete_employee':
        delete_employee($conn);
        break;
    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
}

// --- FIX: Corrected all instances of 'u.user_id' to 'u.id' ---
function fetch_employees($conn) {
    $search = $_GET['search'] ?? '';
    $search_param = "%{$search}%";

    $sql = "SELECT u.id AS id, u.id AS emp_id, u.username AS name, sr.job_title AS position, sr.payment_date, sr.basic_salary, sr.allowances, sr.deductions 
            FROM users u 
            LEFT JOIN (
                SELECT s1.* FROM salary_records s1 
                INNER JOIN (
                    SELECT user_id, MAX(payment_date) AS max_date 
                    FROM salary_records GROUP BY user_id
                ) s2 ON s1.user_id = s2.user_id AND s1.payment_date = s2.max_date
            ) sr ON u.id = sr.user_id 
            WHERE u.role = 'staff' AND (u.username LIKE ? OR sr.job_title LIKE ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $search_param, $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
}

function save_record($conn) {
    $user_id = $_POST['employee_id'] ?? null;
    $name = $_POST['name'];
    $position = $_POST['position'];
    
    $conn->begin_transaction();
    try {
        if (empty($user_id)) {
            $default_password = 'password123';
            $hashed_password = password_hash($default_password, PASSWORD_DEFAULT);
            $role = 'staff';

            $sql_user = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
            $stmt_user = $conn->prepare($sql_user);
            $stmt_user->bind_param("sss", $name, $hashed_password, $role);
            $stmt_user->execute();
            
            $user_id = $conn->insert_id;
            if (!$user_id) {
                throw new Exception("Failed to create new user.");
            }
        }

        $sql_sal = "INSERT INTO salary_records (user_id, payment_date, basic_salary, allowances, deductions, job_title) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_sal = $conn->prepare($sql_sal);
        $stmt_sal->bind_param("isddds", $user_id, $_POST['payment_date'], $_POST['basic_salary'], $_POST['allowances'], $_POST['deductions'], $position);
        $stmt_sal->execute();

        $conn->commit();
        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

function get_salary_details($conn) {
    $user_id = (int)($_GET['id'] ?? 0);
    $allowance_config = ['House Rent Allowance (10%)' => 0.10, 'Travel Allowance (5%)' => 0.05];
    $deduction_config = ['Provident Fund (12%)' => 0.12];
    $sql = "SELECT basic_salary FROM salary_records WHERE user_id = ? ORDER BY payment_date DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $basic_salary = (float)$row['basic_salary'];
        $response = ['status' => 'success', 'basic_salary' => $basic_salary, 'total_allowances' => 0, 'total_deductions' => 0, 'allowance_breakdown' => [], 'deduction_breakdown' => []];
        foreach ($allowance_config as $name => $rate) { $amount = $basic_salary * $rate; $response['total_allowances'] += $amount; $response['allowance_breakdown'][$name] = $amount; }
        foreach ($deduction_config as $name => $rate) { $amount = $basic_salary * $rate; $response['total_deductions'] += $amount; $response['deduction_breakdown'][$name] = $amount; }
        echo json_encode($response);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No previous basic salary found. Please enter amounts manually.']);
    }
}

// --- FIX: Corrected the JOIN condition from 'u.user_id' to 'u.id' ---
function fetch_monthly_summary($conn) {
    $sql = "SELECT DATE_FORMAT(sr.payment_date, '%Y-%m') as month, SUM(sr.basic_salary + sr.allowances - sr.deductions) as total_paid, COUNT(DISTINCT sr.user_id) as employees_paid, SUM(sr.allowances) as total_allowances, SUM(sr.deductions) as total_deductions FROM salary_records sr JOIN users u ON sr.user_id = u.id WHERE sr.payment_date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) AND u.role = 'staff' GROUP BY month ORDER BY month DESC";
    $result = $conn->query($sql);
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
}

function fetch_history($conn) {
    $user_id = (int)($_GET['id'] ?? 0);
    $sql = "SELECT * FROM salary_records WHERE user_id = ? AND payment_date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) ORDER BY payment_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
}

// --- FIX: Corrected 'WHERE user_id = ?' to 'WHERE id = ?' ---
function delete_employee($conn) {
    $id = (int)$_POST['id'];
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) { echo json_encode(['status' => 'success']); } 
    else { echo json_encode(['status' => 'error', 'message' => $stmt->error]); }
}

$conn->close();
?>