<?php
// For debugging purposes. You can remove these two lines later.
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Use the correct filename for your database connection.
include '../Database/db_connect.php';

// --- Reusable function to send a JSON error and exit ---
function send_json_error($message, $conn = null) {
    echo json_encode(['status' => 'error', 'message' => $message]);
    if ($conn) {
        $conn->close();
    }
    exit;
}

if (!isset($conn) || !$conn) {
    send_json_error('Database connection failed. Check db_connect.php.');
}

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

// --- Action Routing ---
switch ($action) {
    case 'fetch':
        fetch_accommodations($conn);
        break;
    case 'add':
        add_accommodation($conn);
        break;
    case 'update':
        update_accommodation($conn);
        break;
    case 'delete':
        delete_accommodation($conn);
        break;
    case 'change_status':
        change_status($conn);
        break;
    default:
        send_json_error('Invalid action specified.', $conn);
}

// --- Functions ---
function fetch_accommodations($conn) {
    // Alias DB columns to what JS expects (acc_id AS id, acc_type AS type)
    $sql = "SELECT acc_id AS id, acc_type AS type, number, price, status, image, description FROM accommodations WHERE 1=1";
    $params = [];
    $types = '';

    // Search filter
    if (!empty($_GET['search'])) {
        $searchTerm = '%' . $_GET['search'] . '%';
        $sql .= " AND (number LIKE ? OR description LIKE ?)";
        array_push($params, $searchTerm, $searchTerm);
        $types .= 'ss';
    }

    // Type filter
    if (!empty($_GET['type'])) {
        $sql .= " AND acc_type = ?";
        $params[] = $_GET['type'];
        $types .= 's';
    }

    // Status filter
    if (!empty($_GET['status'])) {
        $sql .= " AND status = ?";
        $params[] = $_GET['status'];
        $types .= 's';
    }

    // Price filter
    if (!empty($_GET['price'])) {
        $priceRange = $_GET['price'];
        if ($priceRange == '0-5000') $sql .= " AND price BETWEEN 0 AND 5000";
        elseif ($priceRange == '5001-8000') $sql .= " AND price BETWEEN 5001 AND 8000";
        elseif ($priceRange == '8001-15000') $sql .= " AND price BETWEEN 8001 AND 15000";
        elseif ($priceRange == '15000+') $sql .= " AND price >= 15000";
    }
    
    $stmt = $conn->prepare($sql);
    if ($stmt === false) send_json_error('SQL Prepare Error: ' . $conn->error, $conn);
    
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
    $stmt->close();
}

function add_accommodation($conn) {
    $sql = "INSERT INTO accommodations (acc_type, number, price, status, image, description) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) send_json_error('SQL Prepare Error: ' . $conn->error, $conn);
    
    $stmt->bind_param("ssdsss", $_POST['type'], $_POST['number'], $_POST['price'], $_POST['status'], $_POST['image'], $_POST['description']);
    
    if ($stmt->execute()) echo json_encode(['status' => 'success']);
    else send_json_error('Execute Error: ' . $stmt->error, $conn);
    $stmt->close();
}

function update_accommodation($conn) {
    $sql = "UPDATE accommodations SET acc_type=?, number=?, price=?, status=?, image=?, description=? WHERE acc_id=?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) send_json_error('SQL Prepare Error: ' . $conn->error, $conn);
    
    $stmt->bind_param("ssdsssi", $_POST['type'], $_POST['number'], $_POST['price'], $_POST['status'], $_POST['image'], $_POST['description'], $_POST['id']);
    
    if ($stmt->execute()) echo json_encode(['status' => 'success']);
    else send_json_error('Execute Error: ' . $stmt->error, $conn);
    $stmt->close();
}

function delete_accommodation($conn) {
    $sql = "DELETE FROM accommodations WHERE acc_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) send_json_error('SQL Prepare Error: ' . $conn->error, $conn);
    
    $stmt->bind_param("i", $_POST['id']);
    
    if ($stmt->execute()) echo json_encode(['status' => 'success']);
    else send_json_error('Execute Error: ' . $stmt->error, $conn);
    $stmt->close();
}

function change_status($conn) {
    $id = (int)$_POST['id'];
    
    $stmt = $conn->prepare("SELECT status FROM accommodations WHERE acc_id = ?");
    if ($stmt === false) send_json_error('SQL Prepare Error: ' . $conn->error, $conn);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if (!$row) send_json_error('Accommodation not found.', $conn);

    // THIS IS THE CORRECTED LOGIC
    // A switch statement is cleaner and less error-prone than multiple if-else statements.
    $newStatus = '';
    switch ($row['status']) {
        case 'available':
            $newStatus = 'occupied';
            break;
        case 'occupied':
            $newStatus = 'maintenance';
            break;
        case 'maintenance':
            $newStatus = 'available';
            break;
    }
    
    $updateStmt = $conn->prepare("UPDATE accommodations SET status = ? WHERE acc_id = ?");
    if ($updateStmt === false) send_json_error('SQL Prepare Error: ' . $conn->error, $conn);
    
    $updateStmt->bind_param("si", $newStatus, $id);
    
    if ($updateStmt->execute()) echo json_encode(['status' => 'success']);
    else send_json_error('Execute Error: ' . $updateStmt->error, $conn);
    
    $updateStmt->close();
}

$conn->close();
?>