<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit('You must be logged in to perform this action');
}

// Include database connection
require_once 'Connection.php';

// Check if form is submitted
if (isset($_POST['delete_car']) && isset($_POST['car_id'])) {
    $car_id = filter_input(INPUT_POST, 'car_id', FILTER_SANITIZE_NUMBER_INT);
    $user_id = $_SESSION['user_id'];
    
    try {
        // Start a transaction
        $pdo->beginTransaction();
        
        // First verify the car belongs to the user
        $verify_stmt = $pdo->prepare("SELECT 1 FROM cars WHERE car_id = :car_id AND user_id = :user_id");
        $verify_stmt->bindValue(':car_id', $car_id, PDO::PARAM_INT);
        $verify_stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $verify_stmt->execute();
        
        if ($verify_stmt->fetchColumn()) {
            // First delete all inquiries related to this car
            $delete_inquiries = $pdo->prepare("DELETE FROM inquiries WHERE car_id = :car_id");
            $delete_inquiries->bindValue(':car_id', $car_id, PDO::PARAM_INT);
            $delete_inquiries->execute();
            
            // Then delete the car
            $delete_car = $pdo->prepare("DELETE FROM cars WHERE car_id = :car_id AND user_id = :user_id");
            $delete_car->bindValue(':car_id', $car_id, PDO::PARAM_INT);
            $delete_car->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $delete_car->execute();
            
            // Commit the transaction
            $pdo->commit();
            
            // Redirect back to inquiries page with success message
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'Vehicle has been successfully removed'
            ];
        } else {
            // Car doesn't belong to user or doesn't exist
            $_SESSION['flash_message'] = [
                'type' => 'error',
                'message' => 'You do not have permission to delete this vehicle or it does not exist'
            ];
        }
    } catch (Exception $e) {
        // Roll back the transaction on error
        $pdo->rollBack();
        
        $_SESSION['flash_message'] = [
            'type' => 'error',
            'message' => 'An error occurred: ' . $e->getMessage()
        ];
    }
    
    // Redirect back to inquiries page
    header('Location: ../WebPages/seller-inquiries.php');
    exit;
} else {
    // Invalid request
    header('Location: ../WebPages/seller-inquiries.php');
    exit;
}