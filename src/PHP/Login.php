<?php
// Ensure no whitespace or BOM before opening PHP tag
// Disable error display in the output
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Start output buffering to capture any unexpected output
ob_start();

try {
    // Include the database connection
    require_once "Connection.php";
    
    // Start session
    session_start();
    
    // Get POST data from the frontend
    $input_username = $_POST['username'] ?? '';
    $input_password = $_POST['password'] ?? '';
    
    // Clear everything from the output buffer
    ob_clean();
    
    // Validate input
    if (empty($input_username) || empty($input_password)) {
        echo json_encode(["success" => false, "message" => "Username or password cannot be empty"]);
        exit;
    }
    
    // Prepare the SQL statement to prevent SQL injection
    $sql = "SELECT * FROM users WHERE Name = ?";
    $stmt = $pdo->prepare($sql);
    
    // Execute the statement
    $stmt->execute([$input_username]);
    
    // Get the result
    $result = $stmt->fetch();
    if ($result) {
        $user = $result;
        
        // Verify password using PHP's password hashing functions
        if (password_verify($input_password, $user['Password'])) {
            // Store user info in session
            $_SESSION['user_id'] = $user['ID'];
            $_SESSION['username'] = $user['Name'];
            $_SESSION['profile_pic'] = $user['profile_pic'] ?? 'default-avatar.png';
            $_SESSION['isLoggedIn'] = true;
            
            // Create a clean JSON response
            $response = ["success" => true, "message" => "Login successful"];
            
            // Clear any output before JSON output
            while (ob_get_level()) {
                ob_end_clean();
            }
            
            echo json_encode($response);
        } else {
            // Clear any output
            while (ob_get_level()) {
                ob_end_clean();
            }
            echo json_encode(["success" => false, "message" => "Invalid credentials"]);
        }
    } else {
        // Clear any output
        while (ob_get_level()) {
            ob_end_clean();
        }
        echo json_encode(["success" => false, "message" => "Invalid credentials"]);
    }
} catch (Exception $e) {
    // Clean any output before sending error response
    while (ob_get_level()) {
        ob_end_clean();
    }
    echo json_encode(["success" => false, "message" => "Server error: " . $e->getMessage()]);
}

// Important: No closing PHP tag to prevent accidental whitespace