<?php
// File: process_car_listing.php

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user_id']) || !$_SESSION['isLoggedIn']) {
    // User is not logged in, redirect with error message
    header("Location: ../WebPages/AddCar.php?error=login_required");
    exit();
}

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include your PDO database connection file
require_once 'connection.php';

// Function to sanitize and validate input
function sanitizeInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

// Function to handle file uploads
function uploadCarImages($files) {
    $uploadDir = '../Images/CarImages';
    
    // Create upload directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $uploadedFiles = [];
    $maxFiles = 5;
    $maxFileSize = 5 * 1024 * 1024; // 5MB

    // Ensure no more than 5 files are uploaded
    $files = array_slice($files, 0, $maxFiles);

    foreach ($files['car-images'] as $key => $file) {
        // Check for upload errors
        if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
            continue;
        }

        // Validate file size
        if ($file['size'] > $maxFileSize) {
            continue;
        }

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file['type'], $allowedTypes)) {
            continue;
        }

        // Generate unique filename
        $fileName = uniqid('car_') . '_' . basename($file['name']);
        $uploadPath = $uploadDir . $fileName;

        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            $uploadedFiles[] = $fileName;
        }
    }

    return $uploadedFiles ? $uploadedFiles[0] : null; // Return first image path
}

// Function to insert car features
function insertCarFeatures($pdo, $carId, $features) {
    // Feature mapping matching your database
    $featureMap = [
        'leather-seats' => 5,
        'heated-seats' => 8,
        'climate-control' => 7,
        'navigation' => 4,
        'bluetooth' => 2,
        'backup-camera' => 3,
        'alloy-wheels' => 6,
        'sunroof' => 1,
        'cruise-control' => 9
    ];

    // Prepare the statement
    $stmt = $pdo->prepare("INSERT INTO car_features (car_id, feature_id) VALUES (:car_id, :feature_id)");

    // Insert each selected feature
    foreach ($features as $feature) {
        if (isset($featureMap[$feature])) {
            $stmt->execute([
                ':car_id' => $carId,
                ':feature_id' => $featureMap[$feature]
            ]);
        }
    }
}

// Main processing logic
function processCarlisting($pdo, $postData, $files) {
    // Get the logged-in user's ID from the session
    $user_id = $_SESSION['user_id'];
    
    // Sanitize and validate inputs
    $maker = sanitizeInput($postData['brand']);
    $model = sanitizeInput($postData['model']);
    $year = filter_var($postData['year'], FILTER_VALIDATE_INT);
    $price = filter_var($postData['price'], FILTER_VALIDATE_FLOAT);
    
    // Upload car image
    $imagePath = uploadCarImages($files);

    try {
        // Begin transaction
        $pdo->beginTransaction();

        // Prepare SQL statement for cars table (now including user_id)
        $stmt = $pdo->prepare("INSERT INTO cars (maker, model, year, price, image_path, mileage, user_id) VALUES (:maker, :model, :year, :price, :image_path, :mileage, :user_id)");
        
        // Add mileage from the form
        $mileage = filter_var($postData['mileage'], FILTER_VALIDATE_INT);
        
        // Bind parameters
        $stmt->bindParam(':maker', $maker);
        $stmt->bindParam(':model', $model);
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image_path', $imagePath);
        $stmt->bindParam(':mileage', $mileage);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        
        // Execute the statement
        $stmt->execute();
        
        // Get the ID of the newly inserted car
        $carId = $pdo->lastInsertId();
        
        // Insert car features if any were selected
        if (!empty($postData['features'])) {
            insertCarFeatures($pdo, $carId, $postData['features']);
        }

        // Commit transaction
        $pdo->commit();

        // Redirect to success page or listing
        header("Location: ../WebPages/CarSearch.php?success=car_listed");
        exit();

    } catch (PDOException $e) {
        // Rollback transaction
        $pdo->rollBack();

        // Log error and redirect to error page
        error_log("Car Listing Error: " . $e->getMessage());
        header("Location: ../WebPages/AddCar.php?error=" . urlencode($e->getMessage()));
        exit();
    }
}

// Check if form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    processCarlisting($pdo, $_POST, $_FILES);
} else {
    // Redirect if accessed directly
    header("Location: ../WebPages/AddCar.php");
    exit();
}
?>