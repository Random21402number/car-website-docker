<?php
// Prevent direct access
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 403 Forbidden');
    exit('Direct access forbidden');
}

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
require_once '../PHP/Connection.php';

// Log function to help with debugging
function logError($message) {
    // Log to PHP error log
    error_log($message);
    
    // Optionally log to a custom file - create logs directory first
    // file_put_contents('../logs/email_errors.log', date('[Y-m-d H:i:s] ') . $message . "\n", FILE_APPEND);
}

logError("Email process started");

// Get form data
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
$car_id = filter_input(INPUT_POST, 'car_id', FILTER_SANITIZE_NUMBER_INT);

logError("Form data received - Name: $name, Email: $email, Phone: $phone, Car ID: $car_id");

// Validate inputs
if (!$name || !$email || !$message || !$car_id) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

// Fetch car details from database
try {
    $stmt = $pdo->prepare("SELECT c.*, u.Email as seller_email, u.Name as seller_name 
                          FROM cars c
                          LEFT JOIN users u ON c.user_id = u.ID
                          WHERE c.car_id = :car_id");
    $stmt->bindValue(':car_id', $car_id, PDO::PARAM_INT);
    $stmt->execute();
    $car = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$car) {
        logError("Car not found with ID: $car_id");
        echo json_encode(['success' => false, 'message' => 'Car not found']);
        exit;
    }
    
    // Get seller's email address
    $to = isset($car['seller_email']) && !empty($car['seller_email']) ? $car['seller_email'] : '';
    $seller_name = isset($car['seller_name']) && !empty($car['seller_name']) ? $car['seller_name'] : 'Seller';
    
    logError("Seller info - Email: $to, Name: $seller_name");
    
    // If seller's email is empty, use a fallback email
    if (empty($to)) {
        // Try to get admin email from settings
        try {
            $email_stmt = $pdo->prepare("SELECT setting_value FROM email_settings WHERE setting_name = 'reply_to' LIMIT 1");
            $email_stmt->execute();
            $admin_email = $email_stmt->fetchColumn();
            
            if ($admin_email) {
                $to = $admin_email;
                logError("Using admin email from settings: $to");
            } else {
                $to = 'support@carmarket.com'; // Fallback admin email
                logError("Using hardcoded fallback email: $to");
            }
        } catch (PDOException $e) {
            logError("Error getting admin email from settings: " . $e->getMessage());
            $to = 'support@carmarket.com'; // Fallback admin email
        }
    }
    
    // Prepare email content
    $subject = "New inquiry about your {$car['year']} {$car['maker']} {$car['model']}";
    
    // HTML email template
    $html_message = "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: #4a6cf7; color: white; padding: 10px 20px; }
            .content { padding: 20px; border: 1px solid #ddd; }
            .car-details { background-color: #f9f9f9; padding: 15px; margin: 15px 0; }
            .footer { font-size: 12px; color: #777; margin-top: 30px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>New Car Inquiry</h2>
            </div>
            <div class='content'>
                <p>Dear $seller_name,</p>
                <p>You have received a new inquiry about your vehicle listed on CarMarket.</p>
                
                <div class='car-details'>
                    <h3>Vehicle Information:</h3>
                    <p><strong>Make:</strong> {$car['maker']}</p>
                    <p><strong>Model:</strong> {$car['model']}</p>
                    <p><strong>Year:</strong> {$car['year']}</p>
                    <p><strong>Price:</strong> $" . number_format($car['price'], 2) . "</p>
                </div>
                
                <h3>Contact Information:</h3>
                <p><strong>Name:</strong> $name</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Phone:</strong> " . ($phone ? $phone : "Not provided") . "</p>
                
                <h3>Message:</h3>
                <p>" . nl2br($message) . "</p>
                
                <p>Please respond to this inquiry at your earliest convenience.</p>
                <p>Best regards,<br>CarMarket Team</p>
            </div>
            <div class='footer'>
                <p>This email was sent from CarMarket. Please do not reply to this email.</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    // Plain text alternative
    $text_message = "
    New Car Inquiry
    
    Dear $seller_name,
    
    You have received a new inquiry about your vehicle listed on CarMarket.
    
    Vehicle Information:
    Make: {$car['maker']}
    Model: {$car['model']}
    Year: {$car['year']}
    Price: $" . number_format($car['price'], 2) . "
    
    Contact Information:
    Name: $name
    Email: $email
    Phone: " . ($phone ? $phone : "Not provided") . "
    
    Message:
    $message
    
    Please respond to this inquiry at your earliest convenience.
    
    Best regards,
    CarMarket Team
    
    ---
    This email was sent from CarMarket. Please do not reply to this email.
    ";
    
    logError("Preparing to send email to: $to");
    
    // Email headers
    $headers = "From: CarMarket <noreply@carmarket.com>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    
    // IMPORTANT: First, store the inquiry in the database
    $stmt = $pdo->prepare("INSERT INTO inquiries (car_id, name, email, phone, message, created_at) 
                          VALUES (:car_id, :name, :email, :phone, :message, NOW())");
    $stmt->bindValue(':car_id', $car_id, PDO::PARAM_INT);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindValue(':message', $message, PDO::PARAM_STR);
    $db_result = $stmt->execute();
    
    if (!$db_result) {
        logError("Failed to save inquiry to database");
        echo json_encode(['success' => false, 'message' => 'There was an error processing your request.']);
        exit;
    }
    
    logError("Inquiry successfully saved to database");
    
    // LOCALHOST SPECIAL HANDLING:
    // Since mail() often doesn't work on localhost, for localhost we'll just pretend the email was sent
    // This allows testing the functionality without a working mail server
    if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') {
        logError("Running on localhost, skipping actual email sending");
        echo json_encode([
            'success' => true, 
            'message' => 'Your message has been sent. The seller will contact you shortly.',
            'debug_info' => 'Note: Running on localhost, email not actually sent, but inquiry saved to database'
        ]);
        exit;
    }
    
    // Try to send email
    $mail_sent = mail($to, $subject, $html_message, $headers);
    
    if ($mail_sent) {
        logError("Email successfully sent to: $to");
        echo json_encode(['success' => true, 'message' => 'Your message has been sent. The seller will contact you shortly.']);
    } else {
        logError("Email sending failed to: $to");
        // Still return success since the inquiry was saved to database
        echo json_encode([
            'success' => true, 
            'message' => 'Your inquiry has been received. The seller will contact you shortly.',
            'email_status' => 'failed'
        ]);
    }
    
}