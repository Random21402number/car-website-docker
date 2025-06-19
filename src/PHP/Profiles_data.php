<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Function to get user profile data
function getUserProfileData() {
    try {
        // Include the database connection
        require_once "../PHP/Connection.php";
        
        // Get logged-in user's ID from existing session
        $user_id = $_SESSION['user_id'] ?? null;
        if ($user_id) {
            // Query to get user data
            $stmt = $pdo->prepare("SELECT ID, Name, Email, Phone FROM users WHERE ID = :user_id");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            
            // Fetch the user data
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user) {
                // Split the Name into first_name and last_name
                $name_parts = explode(' ', $user['Name'], 2);
                $first_name = $name_parts[0];
                $last_name = isset($name_parts[1]) ? $name_parts[1] : '';
                
                // Create $userData array with retrieved information
                $userData = [
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'phone' => $user['Phone'] ?: '(555) 123-4567', // Use default if empty
                    'email' => $user['Email'],
                    'profile_picture' => '../Images/Profiles/default-avatar.png' // Using default path
                ];
            } else {
                // Fallback if user not found
                $userData = [
                    'first_name' => 'User',
                    'last_name' => 'Not Found',
                    'phone' => '(555) 123-4567',
                    'email' => 'not.found@example.com',
                    'profile_picture' => '../Images/Profiles/default-avatar.png'
                ];
            }
        } else {
            // Fallback if no user ID in session
            $userData = [
                'first_name' => 'Guest',
                'last_name' => 'User',
                'phone' => '(555) 123-4567',
                'email' => 'guest@example.com',
                'profile_picture' => '../Images/Profiles/default-avatar.png'
            ];
        }
    } catch (Exception $e) {
        // Fallback on database error
        $userData = [
            'first_name' => 'error',
            'last_name' => 'error',
            'phone' => 'error',
            'email' => 'error',
            'profile_picture' => '../Images/Profiles/default-avatar.png'
        ];
        
        // Log the error
        error_log("Database error: " . $e->getMessage());
    }
    
    return $userData;
}

// Get user data
$userData = getUserProfileData();
?>