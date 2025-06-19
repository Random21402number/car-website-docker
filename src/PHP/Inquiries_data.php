<?php
// Prevent direct access if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit('You must be logged in to view this page');
}

// Include database connection
require_once '../PHP/Connection.php';

$user_id = $_SESSION['user_id'];

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Function to get unread message count for top navigation
function getUnreadMessageCount($pdo, $user_id) {
    $stmt = $pdo->prepare("
        SELECT COUNT(*) 
        FROM inquiries i
        JOIN cars c ON i.car_id = c.car_id
        WHERE c.user_id = :user_id AND i.is_read = 0
    ");
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
}

// Mark message as read
if (isset($_POST['mark_read']) && isset($_POST['inquiry_id'])) {
    $inquiry_id = filter_input(INPUT_POST, 'inquiry_id', FILTER_SANITIZE_NUMBER_INT);
    
    // Verify this inquiry belongs to the current user
    $verify_stmt = $pdo->prepare("
        SELECT 1 FROM inquiries i
        JOIN cars c ON i.car_id = c.car_id
        WHERE i.inquiry_id = :inquiry_id AND c.user_id = :user_id
    ");
    $verify_stmt->bindValue(':inquiry_id', $inquiry_id, PDO::PARAM_INT);
    $verify_stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $verify_stmt->execute();
    
    if ($verify_stmt->fetchColumn()) {
        $update_stmt = $pdo->prepare("UPDATE inquiries SET is_read = 1 WHERE inquiry_id = :inquiry_id");
        $update_stmt->bindValue(':inquiry_id', $inquiry_id, PDO::PARAM_INT);
        $update_stmt->execute();
    }
    
    // Redirect to prevent form resubmission
    header('Location: ' . $_SERVER['PHP_SELF'] . (isset($_GET['car_id']) ? '?car_id=' . $_GET['car_id'] : ''));
    exit;
}

// Get all cars belonging to the current user
$cars_stmt = $pdo->prepare("
    SELECT car_id, maker, model, year 
    FROM cars 
    WHERE user_id = :user_id 
    ORDER BY car_id DESC
");
$cars_stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$cars_stmt->execute();
$user_cars = $cars_stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the selected car_id from query parameter
$selected_car_id = isset($_GET['car_id']) ? filter_input(INPUT_GET, 'car_id', FILTER_SANITIZE_NUMBER_INT) : null;

// Prepare the query - either for a specific car or all cars
if ($selected_car_id) {
    // Verify the car belongs to the user
    $verify_car_stmt = $pdo->prepare("SELECT 1 FROM cars WHERE car_id = :car_id AND user_id = :user_id");
    $verify_car_stmt->bindValue(':car_id', $selected_car_id, PDO::PARAM_INT);
    $verify_car_stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $verify_car_stmt->execute();
    
    if (!$verify_car_stmt->fetchColumn()) {
        // If car doesn't belong to user, clear the selection
        $selected_car_id = null;
    }
}

// Default query for all cars belonging to the user
$query = "
    SELECT i.*, c.maker, c.model, c.year, c.price, c.image_path
    FROM inquiries i
    JOIN cars c ON i.car_id = c.car_id
    WHERE c.user_id = :user_id
";

$params = [':user_id' => $user_id];

// If a specific car is selected, add that to the query
if ($selected_car_id) {
    $query .= " AND i.car_id = :car_id";
    $params[':car_id'] = $selected_car_id;
}

// Order by is_read (unread first), then by created_at (newest first)
$query .= " ORDER BY i.is_read ASC, i.created_at DESC";

$inquiries_stmt = $pdo->prepare($query);
foreach ($params as $key => $value) {
    $inquiries_stmt->bindValue($key, $value, PDO::PARAM_INT);
}
$inquiries_stmt->execute();
$inquiries = $inquiries_stmt->fetchAll(PDO::FETCH_ASSOC);

// Get unread message count for UI
$unread_count = getUnreadMessageCount($pdo, $user_id);
?>