<?php
// Start the session if it hasn't been started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Define the isLoggedIn variable
$isLoggedIn = isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Easy and secure car transactions with CarMarket.">
    <title>CarMarket</title>
    <link rel="stylesheet" href="../CSS/HeaderFooterIndex.css">
</head>
<body>
    <header>
        <div class="logo">
            <a href="index.php">CarMarket</a>
        </div>
        
        <div class="nav-container">
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    
                    <?php if (!$isLoggedIn): ?>
                        <li><a href="LoginPage.php">Login</a></li>
                        <li><a href="RegisterPage.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
            
            <?php if ($isLoggedIn): ?>
                <div class="profile-container">
                    <img src="../images/profiles/<?php echo htmlspecialchars($_SESSION['profile_pic']); ?>" alt="Profile" class="profile-pic" id="profilePic">
                    <div class="profile-dropdown" id="profileDropdown">
                        <a href="profiles.php">My Profile</a>
                        <a href="../PHP/logout.php">Logout</a>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="hamburger-menu">&#9776;</div>
        </div>
        
    <script src="../JS/HeaderFooterScript.js"></script>
    </header>