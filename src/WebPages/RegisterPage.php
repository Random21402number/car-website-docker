<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - CarMarket</title>
    <link rel="stylesheet" href="../CSS/RegisterStyle.css">
    <script src="../JS/Register.js" defer></script>
</head>
<body>
    <div class="register-container">
        <h1>Create Account</h1>
        
        <form id="registerForm" action="../PHP/Register.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
                <span class="error-message" id="usernameError"></span>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                <span class="error-message" id="emailError"></span>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <span class="error-message" id="passwordError"></span>
            </div>
            
            <div class="toggle-group" >
            <label for="promotionalEmails">Get promotional emails for limited-time deals?</label>
                <div class="toggle">
                    <input type="checkbox" id="temp" name="ToggleSwitch">
                    <span class="toggle-switch" id="ButtonID"></span>
                </div>
            </div>

            <div class="consent-text">
                By joining you agree to our <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a> and confirm you are at least 18 years old.
            </div>
            
            <button type="submit" class="primary-button">Register</button>
            <p class="login-link">Already have an account? <a href="../WebPages/LoginPage.php">Sign in</a></p>
        </form>
    </div>
</body>
</html>