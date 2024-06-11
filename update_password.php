<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $newPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $conn = Database::getInstance()->getConnection();

    // Verify the token
    $stmt = $conn->prepare('SELECT * FROM password_resets WHERE token = ?');
    if ($stmt) {
        $stmt->bind_param('s', $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $email = $row['email'];

            // Update the user's password
            $stmt = $conn->prepare('UPDATE users SET password = ? WHERE email = ?');
            if ($stmt) {
                $stmt->bind_param('ss', $newPassword, $email);
                if ($stmt->execute()) {
                    echo "Password updated successfully.";
                    header("Location: index.php");
                    exit();
                } else {
                    echo "Failed to update password.";
                }
                $stmt->close();
            }
        } else {
            echo "Invalid or expired token.";
        }
        $stmt->close();
    } else {
        echo "Failed to prepare the SQL statement.";
    }
}
?>
