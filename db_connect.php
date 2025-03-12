<?php
$dsn = 'mysql:host=localhost;dbname=user_auth';
$username = 'root';
$password = ''; // Leave this blank for XAMPP

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}
?>
