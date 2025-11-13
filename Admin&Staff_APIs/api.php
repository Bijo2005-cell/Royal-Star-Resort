<?php
// For debugging. You can remove these two lines later.
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// FIX: Use the correct connection file name, which is likely 'db_connect.php'.
include '../Database/db_connect.php'; 

// A helper function to send a JSON error message and exit.
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

// Define the directory for uploads. Ensure this folder exists and is writable.
define('UPLOAD_DIR', '../photos/');

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

// --- Action Routing ---
switch ($action) {
    case 'fetch':
        fetch_programs($conn);
        break;
    case 'save':
        save_program($conn);
        break;
    case 'delete':
        delete_program($conn);
        break;
    default:
        send_json_error('Invalid action specified.', $conn);
}

// --- Functions ---
function fetch_programs($conn) {
    // FIX: This function now uses prepared statements to prevent SQL injection.
    // FIX: It queries the correct 'programs' table and creates the 'id' and 'dates' fields the frontend expects.
    $sql = "SELECT 
                program_id AS id, 
                type, 
                title, 
                description, 
                price, 
                image,
                CASE
                    WHEN valid_from IS NOT NULL AND valid_to IS NOT NULL THEN CONCAT(DATE_FORMAT(valid_from, '%b %d'), ' to ', DATE_FORMAT(valid_to, '%b %d, %Y'))
                    WHEN valid_from IS NOT NULL THEN CONCAT('Starts ', DATE_FORMAT(valid_from, '%b %d, %Y'))
                    ELSE 'Ongoing'
                END AS dates
            FROM programs WHERE 1=1";

    $params = [];
    $types = '';

    // Filter by type (package, event, etc.)
    if (!empty($_GET['filter']) && $_GET['filter'] !== 'all') {
        $sql .= " AND type = ?";
        $params[] = $_GET['filter'];
        $types .= 's';
    }

    // Filter by search term
    if (!empty($_GET['search'])) {
        $searchTerm = '%' . $_GET['search'] . '%';
        $sql .= " AND (title LIKE ? OR description LIKE ?)";
        array_push($params, $searchTerm, $searchTerm);
        $types .= 'ss';
    }
    
    $sql .= " ORDER BY program_id DESC";
    
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

function save_program($conn) {
    $id = empty($_POST['id']) ? 0 : (int)$_POST['id'];
    $type = $_POST['type'] ?? '';
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? '0';
    $imagePath = null;
    
    // Handle File Upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileName = time() . '_' . basename($_FILES['image']['name']);
        $targetPath = UPLOAD_DIR . $fileName;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $imagePath = $targetPath;
        } else {
            send_json_error('Failed to move uploaded file.', $conn);
        }
    }

    // FIX: All queries now use the correct table 'programs' and column 'program_id'.
    if ($id > 0) { // UPDATE
        // FIX: Added logic to delete the old image file if a new one is uploaded.
        if ($imagePath) {
            $stmt = $conn->prepare("SELECT image FROM programs WHERE program_id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $oldImage = $stmt->get_result()->fetch_assoc()['image'];
            if ($oldImage && file_exists($oldImage)) {
                unlink($oldImage);
            }
        }
        
        $sql = "UPDATE programs SET type=?, title=?, description=?, price=?" . ($imagePath ? ", image=?" : "") . " WHERE program_id=?";
        $stmt = $conn->prepare($sql);
        if ($imagePath) {
            $stmt->bind_param("sssssi", $type, $title, $description, $price, $imagePath, $id);
        } else {
            $stmt->bind_param("ssssi", $type, $title, $description, $price, $id);
        }
    } else { // INSERT
        $sql = "INSERT INTO programs (type, title, description, price, image) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $type, $title, $description, $price, $imagePath);
    }

    if ($stmt->execute()) echo json_encode(['status' => 'success']);
    else send_json_error('Execute Error: ' . $stmt->error, $conn);
    $stmt->close();
}

function delete_program($conn) {
    $id = (int)$_POST['id'];

    // FIX: Added logic to delete the image file from the server when the record is deleted.
    $stmt = $conn->prepare("SELECT image FROM programs WHERE program_id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    if ($row = $stmt->get_result()->fetch_assoc()) {
        if ($row['image'] && file_exists($row['image'])) {
            unlink($row['image']); // Delete the image file
        }
    }
    $stmt->close();

    $stmt = $conn->prepare("DELETE FROM programs WHERE program_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) echo json_encode(['status' => 'success']);
    else send_json_error('Execute Error: ' . $stmt->error, $conn);
    $stmt->close();
}

$conn->close();
?>