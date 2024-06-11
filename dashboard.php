<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav>z
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="search_books.php">Search Books</a></li>
            <li><a href="add_book.php">Add Book</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <div class="container">
        <h1>Welcome to the Dashboard</h1>
        <p>Use the navigation bar to search for books, add new books, or log out.</p>
    </div>
</body>
</html>
