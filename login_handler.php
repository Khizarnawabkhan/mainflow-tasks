<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        header("Location: login.php?error=Username and password are required");
        exit();
    }

    // Retrieve user data (Prepared Statement)
    $sql = "SELECT id, username, password FROM users WHERE username = ? OR email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username, $username]);  // Use username twice to check both username and email

    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Regenerate session ID
        session_regenerate_id(true);

        // Store user data in session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Redirect to dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        header("Location: login.php?error=Incorrect username/email or password");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>
