<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = Database::getInstance()->getConnection();

    // Prepare the statement correctly
    $stmt = $conn->prepare('SELECT * FROM users WHERE username = ?');
    if ($stmt) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if a user is found and verify the password
        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['user'] = $username;
                $_SESSION['email'] = $row['email'];
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Invalid login credentials.";
            }
        } else {
            echo "Invalid login credentials.";
        }
        $stmt->close();
    } else {
        echo "Failed to prepare the SQL statement.";
    }
}
?>
