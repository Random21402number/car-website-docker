<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarMarket - User Profile</title>
    
    <!-- Link to external CSS files for styling -->
    <link rel="stylesheet" href="../CSS/HeaderFooterIndex.css">
    <link rel="stylesheet" href="../CSS/IndexStyles.css">
    <link rel="stylesheet" href="../CSS/Profiles.css">
</head>
<body>

<?php
// Include header
include '../PHP/header.php';

// Include the profile data backend logic
require_once '../PHP/Profiles_data.php';
?>

<main>
    <!-- Profile container -->
    <div class="user-profile-container">
        <!-- Profile header with name and profile picture -->
        <div class="profile-header">
            <div class="profile-picture">
                <img src="<?php echo $userData['profile_picture']; ?>" alt="Profile Picture">
            </div>
            <h1><?php echo $userData['first_name'] . ' ' . $userData['last_name']; ?></h1>
        </div>
        
        <!-- Profile information section -->
        <div class="profile-info">
            <!-- First Name -->
            <div class="info-item">
                <div class="info-label">First Name:</div>
                <div class="info-value"><?php echo $userData['first_name']; ?></div>
            </div>
            
            <!-- Last Name -->
            <div class="info-item">
                <div class="info-label">Last Name:</div>
                <div class="info-value"><?php echo $userData['last_name']; ?></div>
            </div>
            
            <!-- Phone -->
            <div class="info-item">
                <div class="info-label">Phone:</div>
                <div class="info-value"><?php echo $userData['phone']; ?></div>
            </div>
            
            <!-- Email -->
            <div class="info-item">
                <div class="info-label">Email:</div>
                <div class="info-value"><?php echo $userData['email']; ?></div>
            </div>
            
            <div class="profile-actions">
                <a href="Seller-Inquiries.php" class="action-button inquiries-button">View Seller Inquiries</a>
            </div>


        </div>
    </div>
</main>

<?php
// Include footer
include '../PHP/footer.php';
?>

</body>
</html>