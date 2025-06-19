<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit('You must be logged in to view this page');
}

// Include database connection
require_once '../PHP/Connection.php';

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Function to get all available features
function getAllFeatures($pdo) {
    $stmt = $pdo->query("SELECT * FROM features ORDER BY feature_name");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get features for a specific car
function getCarFeatures($pdo, $car_id) {
    $stmt = $pdo->prepare("
        SELECT feature_id 
        FROM car_features 
        WHERE car_id = :car_id
    ");
    $stmt->bindValue(':car_id', $car_id, PDO::PARAM_INT);
    $stmt->execute();
    
    $features = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $features[] = $row['feature_id'];
    }
    
    return $features;
}

// Check if form is submitted to update car
if (isset($_POST['update_car']) && isset($_POST['car_id'])) {
    $car_id = filter_input(INPUT_POST, 'car_id', FILTER_SANITIZE_NUMBER_INT);
    
    // Validate car belongs to user
    $verify_stmt = $pdo->prepare("SELECT 1 FROM cars WHERE car_id = :car_id AND user_id = :user_id");
    $verify_stmt->bindValue(':car_id', $car_id, PDO::PARAM_INT);
    $verify_stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $verify_stmt->execute();
    
    if (!$verify_stmt->fetchColumn()) {
        $_SESSION['flash_message'] = [
            'type' => 'error',
            'message' => 'You do not have permission to edit this vehicle'
        ];
        header('Location: ../WebPages/seller-inquiries.php');
        exit;
    }
    
    // Sanitize and validate input
    $maker = filter_input(INPUT_POST, 'maker', FILTER_SANITIZE_STRING);
    $model = filter_input(INPUT_POST, 'model', FILTER_SANITIZE_STRING);
    $year = filter_input(INPUT_POST, 'year', FILTER_SANITIZE_NUMBER_INT);
    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $mileage = filter_input(INPUT_POST, 'mileage', FILTER_SANITIZE_NUMBER_INT);
    $image_path = filter_input(INPUT_POST, 'image_path', FILTER_SANITIZE_URL);
    
    // Validate features
    $features = isset($_POST['features']) ? $_POST['features'] : [];
    $features = array_filter($features, function($feature_id) {
        return filter_var($feature_id, FILTER_VALIDATE_INT) !== false;
    });
    
    try {
        // Begin transaction
        $pdo->beginTransaction();
        
        // Update car details
        $update_stmt = $pdo->prepare("
            UPDATE cars 
            SET maker = :maker, model = :model, year = :year, price = :price, 
                mileage = :mileage, image_path = :image_path
            WHERE car_id = :car_id AND user_id = :user_id
        ");
        
        $update_stmt->bindValue(':maker', $maker);
        $update_stmt->bindValue(':model', $model);
        $update_stmt->bindValue(':year', $year, PDO::PARAM_INT);
        $update_stmt->bindValue(':price', $price);
        $update_stmt->bindValue(':mileage', $mileage, PDO::PARAM_INT);
        $update_stmt->bindValue(':image_path', $image_path);
        $update_stmt->bindValue(':car_id', $car_id, PDO::PARAM_INT);
        $update_stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        
        $update_stmt->execute();
        
        // Delete all existing features for this car
        $delete_features_stmt = $pdo->prepare("DELETE FROM car_features WHERE car_id = :car_id");
        $delete_features_stmt->bindValue(':car_id', $car_id, PDO::PARAM_INT);
        $delete_features_stmt->execute();
        
        // Insert new features
        if (!empty($features)) {
            $insert_features_stmt = $pdo->prepare("INSERT INTO car_features (car_id, feature_id) VALUES (:car_id, :feature_id)");
            
            foreach ($features as $feature_id) {
                $insert_features_stmt->bindValue(':car_id', $car_id, PDO::PARAM_INT);
                $insert_features_stmt->bindValue(':feature_id', $feature_id, PDO::PARAM_INT);
                $insert_features_stmt->execute();
            }
        }
        
        // Commit transaction
        $pdo->commit();
        
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => 'Vehicle details updated successfully'
        ];
        
        // Redirect back to inquiries page
        header('Location: ../WebPages/seller-inquiries.php');
        exit;
        
    } catch (Exception $e) {
        // Roll back transaction on error
        $pdo->rollBack();
        
        $error_message = "An error occurred: " . $e->getMessage();
        
        // If this is an AJAX request, return JSON
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => $error_message]);
            exit;
        }
        
        // Otherwise, set error message for display on form
        $_SESSION['flash_message'] = [
            'type' => 'error',
            'message' => $error_message
        ];
        
        header('Location: ../WebPages/EditCar.php?car_id=' . $car_id);
        exit;
    }
}

// Check if we're on the edit page and need to load car data
if (basename($_SERVER['PHP_SELF']) === 'EditCar.php') {
    // Get car ID from query parameter
    $car_id = filter_input(INPUT_GET, 'car_id', FILTER_SANITIZE_NUMBER_INT);
    
    if (!$car_id) {
        $error_message = "No vehicle specified.";
    } else {
        // Get car details
        $car_stmt = $pdo->prepare("
            SELECT * FROM cars 
            WHERE car_id = :car_id AND user_id = :user_id
        ");
        
        $car_stmt->bindValue(':car_id', $car_id, PDO::PARAM_INT);
        $car_stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $car_stmt->execute();
        
        $car = $car_stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$car) {
            $error_message = "Vehicle not found or you don't have permission to edit it.";
        } else {
            // Get all available features
            $all_features = getAllFeatures($pdo);
            
            // Get features for this car
            $car_features = getCarFeatures($pdo, $car_id);
            
            // Check for flash messages
            if (isset($_SESSION['flash_message'])) {
                if ($_SESSION['flash_message']['type'] === 'error') {
                    $error_message = $_SESSION['flash_message']['message'];
                } else {
                    $success_message = $_SESSION['flash_message']['message'];
                }
                
                // Clear the message
                unset($_SESSION['flash_message']);
            }
        }
    }
}