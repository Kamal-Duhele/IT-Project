<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

include('db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $conn = Database::getInstance()->getConnection();

    // Get the book details
    $stmt = $conn->prepare('SELECT * FROM books WHERE id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $filePath = $row['file_path'];
            if (file_exists($filePath)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filePath));
                readfile($filePath);
                exit;
            } else {
                echo "File not found.";
            }
        } else {
            echo "No book found with that ID.";
        }
        $stmt->close();
    } else {
        echo "Failed to prepare the SQL statement.";
    }
}
?>
