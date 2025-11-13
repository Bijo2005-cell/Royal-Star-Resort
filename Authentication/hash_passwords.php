<?php
require '../Database/db_connect.php'; // Make sure this path is correct

echo "<h1>Starting Password Update...</h1>";

// This function checks if a string is likely a modern PHP hash
function is_hashed($password) {
    // PASSWORD_DEFAULT hashes are always 60 characters long and start with $2y$
    return strlen($password) === 60 && strpos($password, '$2y$') === 0;
}

// Fetch all users
$result = $conn->query("SELECT user_id, password FROM users");

if ($result && $result->num_rows > 0) {
    while ($user = $result->fetch_assoc()) {
        $userId = $user['user_id'];
        $currentPassword = $user['password'];

        // Only hash the password if it's NOT already hashed
        if (!is_hashed($currentPassword)) {
            echo "Found plain-text password for user ID: {$userId}. Hashing now...<br>";
            
            // Generate a secure hash
            $hashedPassword = password_hash($currentPassword, PASSWORD_DEFAULT);

            // Update the user's record
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
            $stmt->bind_param("si", $hashedPassword, $userId);
            
            if ($stmt->execute()) {
                echo "<strong>SUCCESS:</strong> Password for user ID {$userId} has been updated.<br><hr>";
            } else {
                echo "<strong>ERROR:</strong> Could not update password for user ID {$userId}.<br><hr>";
            }
            $stmt->close();
        } else {
            echo "Password for user ID: {$userId} is already hashed. Skipping.<br><hr>";
        }
    }
} else {
    echo "No users found.";
}

echo "<h2>Update process complete. Please delete this file now.</h2>";

$conn->close();
?>