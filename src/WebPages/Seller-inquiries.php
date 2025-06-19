<!DOCTYPE html>
<head lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Inquiries | CarMarket</title>
    <link rel="stylesheet" href="../CSS/CarDetails.css">
    <link rel="stylesheet" href="../CSS/CarInquiries.css">
</head>

<body>
    <?php
    // Include header
    include '../PHP/header.php';
    ?>

<?php
// Include the data processing file
require_once '../PHP/Inquiries_data.php';
?>

    <main class="car-details-page">
        <div class="back-button-container">
            <a href="../WebPages/Profiles.php" class="back-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5"></path>
                    <path d="M12 19l-7-7 7-7"></path>
                </svg>
                Back to Profile
            </a>
        </div>

        <h1>My Inquiries</h1>
        
        <div class="inbox-container">
        <div class="sidebar">
    <h3>My Vehicles</h3>
    <ul class="car-list">
        <li>
            <a href="seller-inquiries.php" <?php echo !$selected_car_id ? 'class="active"' : ''; ?>>
                All Vehicles <?php echo $unread_count > 0 ? "({$unread_count})" : ''; ?>
            </a>
        </li>
        <?php foreach ($user_cars as $car): ?>
            <li class="car-list-item">
                <div class="car-list-main">
                    <a href="seller-inquiries.php?car_id=<?php echo $car['car_id']; ?>" 
                       <?php echo $selected_car_id == $car['car_id'] ? 'class="active"' : ''; ?>>
                        <?php echo htmlspecialchars($car['year'] . ' ' . $car['maker'] . ' ' . $car['model']); ?>
                    </a>
                </div>
                <div class="car-actions">
                    <a href="../WebPages/EditCar.php?car_id=<?php echo $car['car_id']; ?>" class="car-edit-btn" title="Edit Car">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                        </svg>
                    </a>
                    <button class="car-delete-btn" title="Remove Car" data-car-id="<?php echo $car['car_id']; ?>" data-car-name="<?php echo htmlspecialchars($car['year'] . ' ' . $car['maker'] . ' ' . $car['model']); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        </svg>
                    </button>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
            
    <div class="inbox-messages">
        <div class="inbox-header">
                <h2>
                    <?php 
                    if ($selected_car_id && count($user_cars) > 0) {
                        foreach ($user_cars as $car) {
                            if ($car['car_id'] == $selected_car_id) {
                                echo 'Inquiries for ' . htmlspecialchars($car['year'] . ' ' . $car['maker'] . ' ' . $car['model']);
                                break;
                            }
                        }
                    } else {
                        echo 'All Inquiries';
                    }
                    ?>
                    </h2>
                    <div class="message-count">
                        <span><?php echo count($inquiries); ?> messages</span>
                        <?php if ($unread_count > 0): ?>
                            <span>, <strong><?php echo $unread_count; ?> unread</strong></span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <?php if (count($inquiries) > 0): ?>
                    <ul class="message-list">
                        <?php foreach ($inquiries as $inquiry): ?>
                            <li class="message-item <?php echo $inquiry['is_read'] ? '' : 'unread'; ?>" data-id="<?php echo $inquiry['inquiry_id']; ?>">
                                <div class="message-header">
                                    <div class="sender-info"><?php echo htmlspecialchars($inquiry['name']); ?> (<?php echo htmlspecialchars($inquiry['email']); ?>)</div>
                                    <div class="message-date"><?php echo date('M d, Y g:i A', strtotime($inquiry['created_at'])); ?></div>
                                </div>
                                <div class="car-info">
                                    <?php echo htmlspecialchars($inquiry['year'] . ' ' . $inquiry['maker'] . ' ' . $inquiry['model']); ?> - 
                                    $<?php echo number_format($inquiry['price'], 2); ?>
                                </div>
                                <div class="message-preview"><?php echo htmlspecialchars(substr($inquiry['message'], 0, 100) . (strlen($inquiry['message']) > 100 ? '...' : '')); ?></div>
                                <div class="message-content" id="content-<?php echo $inquiry['inquiry_id']; ?>">
                                    <p><?php echo nl2br(htmlspecialchars($inquiry['message'])); ?></p>
                                    
                                    <?php if ($inquiry['phone']): ?>
                                        <p><strong>Phone:</strong> <?php echo htmlspecialchars($inquiry['phone']); ?></p>
                                    <?php endif; ?>
                                    
                                    <div class="message-actions">
                                    <?php
                                    // Create Gmail compose URL with pre-filled fields

                                    $recipient = urlencode($inquiry['email']);
                                    $subject = urlencode("RE: Your inquiry about " . $inquiry['year'] . " " . $inquiry['maker'] . " " . $inquiry['model']);

                                    $decoded_message = html_entity_decode($inquiry['message']);

                                    // Create a template for the email body
                                    $body = urlencode("Hello " . $inquiry['name'] . ",\n\nThank you for your interest in the " . 
                                    $inquiry['year'] . " " . $inquiry['maker'] . " " . $inquiry['model'] . ".\n\n" . 
                                    "I'm writing in response to your inquiry: \n\n\"" . $decoded_message . "\"\n\n" .
                                    "Please let me know if you have any other questions or if you'd like to schedule a viewing.\n\n" .
                                    "Best regards");
    
                                    $gmail_url = "https://mail.google.com/mail/?view=cm&fs=1&to={$recipient}&su={$subject}&body={$body}";
                                    // ?>
                                    <a href="<?php echo $gmail_url; ?>" target="_blank" class="reply-btn">Reply via Gmail</a>
                                        
                                        <?php if (!$inquiry['is_read']): ?>
                                            <form method="post" style="display: inline;">
                                                <input type="hidden" name="inquiry_id" value="<?php echo $inquiry['inquiry_id']; ?>">
                                                <input type="hidden" name="mark_read" value="1">
                                                <button type="submit" class="mark-read-btn">Mark as Read</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <div class="empty-state">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                            <path d="M22 7l-10 7L2 7"></path>
                        </svg>
                        <h3>No inquiries yet</h3>
                        <p>When potential buyers contact you about your vehicles, their messages will appear here.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div id="deleteCarModal" class="modal">
            <div class="modal-content">
                <span class="close-modal">&times;</span>
                <h2>Confirm Deletion</h2>
                <p>Are you sure you want to remove <span id="carToDeleteName"></span>?</p>
                <p class="warning">This action cannot be undone. All inquiries related to this vehicle will also be deleted.</p>
                <div class="modal-actions">
                    <button id="cancelDeleteBtn" class="cancel-btn">Cancel</button>
                    <form id="deleteCarForm" method="post" action="../PHP/CarDeletion.php">
                        <input type="hidden" id="carIdToDelete" name="car_id">
                        <input type="hidden" name="delete_car" value="1">
                        <button type="submit" class="delete-btn">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script src="../JS/Inquiries.js"></script>
</body>
</head>