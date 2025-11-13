<?php
session_start();
header('Content-Type: application/json');

// Check if the user is logged in
if (!isset($_SESSION['employee_id'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

include 'db.php';
$employee_id = $_SESSION['employee_id'];

// 1. Fetch employee profile data
$stmt_profile = $conn->prepare("SELECT emp_id, name, position, department, photo_url FROM employees WHERE id = ?");
$stmt_profile->bind_param("i", $employee_id);
$stmt_profile->execute();
$profile_result = $stmt_profile->get_result();
$employee_data = $profile_result->fetch_assoc();

if (!$employee_data) {
    echo json_encode(['error' => 'Employee not found']);
    exit;
}

// 2. Fetch employee salary history (last 6 months)
$stmt_history = $conn->prepare(
    "SELECT 
        DATE_FORMAT(payment_date, '%M %Y') as month,
        basic_salary as basic,
        allowances,
        deductions,
        payment_date as date 
    FROM salary_records 
    WHERE employee_id = ? AND payment_date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
    ORDER BY payment_date ASC"
);
$stmt_history->bind_param("i", $employee_id);
$stmt_history->execute();
$history_result = $stmt_history->get_result();
$salary_history = $history_result->fetch_all(MYSQLI_ASSOC);

// 3. Combine profile and history into one JSON object
$employee_data['salaryHistory'] = $salary_history;

echo json_encode($employee_data);

$conn->close();
?>