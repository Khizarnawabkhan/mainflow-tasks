<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        header("Location: signup.php?error=All fields are required");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: signup.php?error=Invalid email format");
        exit();
    }

    if ($password !== $confirm_password) {
        header("Location: signup.php?error=Passwords do not match");
        exit();
    }

    // Check if username or email already exists (Prepared Statement)
    $sql = "SELECT id FROM users WHERE username = ? OR email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username, $email]);

    if ($stmt->fetch()) {
        header("Location: signup.php?error=Username or Email already exists");
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data (Prepared Statement)
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute([$username, $email, $hashedPassword]);
        // Redirect to login page after successful signup
        header("Location: login.php?signup=success");
        exit();

    } catch (PDOException $e) {
        error_log("Signup error: " . $e->getMessage()); // Log the error
        header("Location: signup.php?error=Signup failed. Please try again.");
        exit();
    }
} else {
    header("Location: signup.php");
    exit();
}
?>
