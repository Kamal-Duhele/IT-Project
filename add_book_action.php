<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $address = $_POST['address'];

    $conn = Database::getInstance()->getConnection();

    // Insert book details into the database
    $stmt = $conn->prepare('INSERT INTO books (title, author, file_path) VALUES (?, ?, ?)');
    if ($stmt) {
        $stmt->bind_param('sss', $title, $author, $address);
        if ($stmt->execute()) {
            echo "Book added successfully.";
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Failed to add book.";
        }
        $stmt->close();
    } else {
        echo "Failed to prepare the SQL statement.";
    }
}
?>
