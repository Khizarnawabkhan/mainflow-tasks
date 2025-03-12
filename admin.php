<?php
// admin.php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// You might want to fetch user data from the database here, for example:
// require_once 'db_connect.php';
// $sql = "SELECT * FROM users WHERE id = ?";
// $stmt = $pdo->prepare($sql);
// $stmt->execute([$_SESSION['user_id']]);
// $user = $stmt->fetch();

$username = htmlspecialchars($_SESSION['username']); // Sanitize output!

?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Admin Dashboard</h2>
        <p>Welcome, <b><?php echo $username; ?></b>!</p>
        <p>This is the admin area.  You can add administrative functions here.</p>
        <ul>
            <li><a href="#">Manage Users</a></li>
            <li><a href="#">View Reports</a></li>
            <li><a href="#">Update Settings</a></li>
        </ul>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
