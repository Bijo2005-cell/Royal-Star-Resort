<?php
// Test database connection

// Display all errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
require_once '../Database/db_connect.php';

// HTML header
echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Database Connection Test</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        h1 { color: #333; }
        .success { color: green; background: #f0fff0; padding: 10px; border-left: 5px solid green; }
        .error { color: red; background: #fff0f0; padding: 10px; border-left: 5px solid red; }
        .info { background: #f0f0ff; padding: 10px; border-left: 5px solid blue; margin: 10px 0; }
        pre { background: #f4f4f4; padding: 10px; border-radius: 5px; overflow-x: auto; }
    </style>
</head>
<body>
    <h1>Database Connection Test</h1>";

// Test connection
if ($conn->connect_error) {
    echo "<div class='error'>
        <h2>Connection Failed</h2>
        <p>Error: " . $conn->connect_error . "</p>
        <h3>Troubleshooting:</h3>
        <ol>
            <li>Check if MySQL server is running</li>
            <li>Verify database credentials in db_connect.php</li>
            <li>Make sure the database 'royal_star_resort' exists</li>
            <li>Run the setup_database.php script to create the database</li>
        </ol>
    </div>";
} else {
    echo "<div class='success'>
        <h2>Connection Successful!</h2>
        <p>Successfully connected to the database 'royal_star_resort'.</p>
    </div>";
    
    // Test tables
    echo "<div class='info'><h3>Checking Database Tables:</h3>";
    
    $tables = ['users', 'accommodation', 'booking', 'leave_requests'];
    $allTablesExist = true;
    
    foreach ($tables as $table) {
        $result = $conn->query("SHOW TABLES LIKE '$table'");
        
        if ($result->num_rows > 0) {
            echo "<p>✅ Table '$table' exists</p>";
            
            // Count records
            $countResult = $conn->query("SELECT COUNT(*) as count FROM $table");
            $row = $countResult->fetch_assoc();
            echo "<p style='margin-left: 20px;'>- Contains {$row['count']} records</p>";
        } else {
            echo "<p>❌ Table '$table' does not exist</p>";
            $allTablesExist = false;
        }
    }
    
    echo "</div>";
    
    // Show next steps
    if (!$allTablesExist) {
        echo "<div class='info'>
            <h3>Missing Tables Detected</h3>
            <p>Some database tables are missing. Please run the setup script:</p>
            <p><a href='setup_database.php' style='display: inline-block; padding: 10px 15px; background: #4CAF50; color: white; text-decoration: none; border-radius: 4px;'>Run Database Setup</a></p>
        </div>";
    } else {
        echo "<div class='info'>
            <h3>All Set!</h3>
            <p>Your database is properly configured and ready to use.</p>
            <p>You can now proceed with using the application.</p>
        </div>";
    }
    
    // Show connection details
    echo "<div class='info'>
        <h3>Connection Details:</h3>
        <ul>
            <li><strong>Server:</strong> {$servername}</li>
            <li><strong>Database:</strong> {$dbname}</li>
            <li><strong>User:</strong> {$username}</li>
            <li><strong>Character Set:</strong> " . $conn->character_set_name() . "</li>
        </ul>
    </div>";
}

// Close connection
$conn->close();

echo "</body>
</html>";
?>