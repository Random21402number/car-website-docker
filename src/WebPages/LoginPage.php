<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CarMarket</title>
    <link rel="stylesheet" href="../CSS/LoginStyles.css">
    <script src="../JS/Login.js" defer></script>
</head>
<body>
    <div class="login-container">
        <h1>Sign In</h1>
        <form id="login-form">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username">
        <span class="error" id="usernameError"></span>
    </div>
    
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password">
        <span class="error" id="passwordError"></span>
    </div>
    
    <button type="submit">Sign In</button>
    <p class="register-link">Don't have an account? <a href="../WebPages/RegisterPage.php">Register</a></p>
</form>
    </div>
</body>
</html>