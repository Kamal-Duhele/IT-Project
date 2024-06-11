<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $conn = Database::getInstance()->getConnection();

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Normally, here you would send an email with the reset link
        echo "<script>alert('A reset password link has been sent to the corresponding email.'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('No user found with that email ID. Please recheck the email ID and resubmit.'); window.location.href='reset_request.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
