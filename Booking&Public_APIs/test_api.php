<?php
// A simple script to test the Google Gemini API connection directly.

// ▼▼▼ PASTE YOUR NEWEST API KEY FROM AI STUDIO HERE ▼▼▼
$apiKey = 'AIzaSyBnn4TpptOSCLMUsxaXoe431GnCalFm4CQ';


// --- THE REST OF THE CODE IS FOR TESTING ---
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>API Key Test</h1>";
echo "<p><strong>Testing Key:</strong> " . substr($apiKey, 0, 8) . "..." . substr($apiKey, -4) . "</p><hr>";

$apiUrl = 'https://generativelanguage.googleapis.com/v1/models/gemini-1.5-flash-latest:generateContent?key=' . $apiKey;
$postData = ['contents' => [['parts' => [['text' => 'Hello.']]]]];

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Enforce SSL verification

$response = curl_exec($ch);

if ($response === false) {
    echo "<h2>cURL Execution Failed</h2>";
    echo "<p><strong>Error Message:</strong> " . curl_error($ch) . "</p>";
} else {
    echo "<h2>API Server Response:</h2>";
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    echo "<p><strong>HTTP Status Code:</strong> " . $http_code . "</p>";
    echo "<h3>Response Body:</h3>";
    echo "<pre>" . htmlspecialchars($response) . "</pre>";
}

curl_close($ch);
?>