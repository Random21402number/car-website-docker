<?php
// Save this file as check-session.php in your PHP folder

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Prepare response
$response = [
    'isLoggedIn' => isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true,
    'session_id' => session_id()
];

// Add user info if logged in
if (isset($_SESSION['user_id'])) {
    $response['user_id'] = $_SESSION['ID'];
    $response['username'] = $_SESSION['Name'] ?? 'Not set';
    $response['profile_pic'] = $_SESSION['profile_pic'] ?? 'Not set';
}

// Return as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>