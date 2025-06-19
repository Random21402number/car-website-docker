<?php
require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));
    $email = htmlspecialchars(trim($_POST['email']));

    // Basic validation
    if (strlen($username) < 3) {
        setcookie('registration_error', 'Username must be at least 3 characters long.', time() + 60, '/');
        header('Location: ../WebPages/RegisterPage.php');
        exit;
    }
    if (strlen($password) < 6) {
        setcookie('registration_error', 'Password must be at least 6 characters long.', time() + 60, '/');
        header('Location: ../WebPages/RegisterPage.php');
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        setcookie('registration_error', 'Invalid email address.', time() + 60, '/');
        header('Location: ../WebPages/RegisterPage.php');
        exit;
    }

    try {
        global $pdo;
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE Name = ? OR Email = ?');
        $stmt->execute([$username, $email]);
        if ($stmt->fetchColumn() > 0) {
            setcookie('registration_error', 'Username or email already exists.', time() + 60, '/');
            header('Location: ../WebPages/RegisterPage.php');
            exit;
        }

        $stmt = $pdo->prepare('INSERT INTO users (Name, password, email) VALUES (?, ?, ?)');
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt->execute([$username, $hashedPassword, $email]);

        // Start session and set user data
        session_start();
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['username'] = $username;
        
        // Redirect to home page
        header('Location: ../WebPages/index.php');
        exit;
    } catch (PDOException $e) {
        setcookie('registration_error', 'Database error: ' . $e->getMessage(), time() + 60, '/');
        header('Location: ../WebPages/RegisterPage.php');
        exit;
    }
} else {
    header('Location: ../WebPages/RegisterPage.php');
    exit;
}
?>