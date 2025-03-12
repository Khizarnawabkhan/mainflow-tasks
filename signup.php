<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require 'db_connect.php'; // Ensure db_connect.php works

    // Step 1: Collect the form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Step 2: Check for empty fields
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        die("All fields are required.");
    }

    // Step 3: Check if passwords match
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Step 4: Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Step 5: Check if the username or email already exists
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        $user = $stmt->fetch();

        if ($user) {
            die("Username or Email already exists.");
        }

        // Step 6: Insert the data into the database
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword]);
        echo "Signup successful!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
