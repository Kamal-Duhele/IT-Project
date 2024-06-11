<?php
include('db.php');

if (isset($_GET['token'])) {
    $token = $_GET['token'];
} else {
    die("No token provided.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Reset Password</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Reset Password</h1>
    <form action="update_password.php" method="POST">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Reset Password</button>
    </form>
    <p><a href="index.php">Back to Login</a></p>
</body>
</html>
