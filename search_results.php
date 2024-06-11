<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

include('db.php');

$searchResults = [];
if (isset($_GET['query'])) {
    $query = $_GET['query'];

    $conn = Database::getInstance()->getConnection();

    $stmt = $conn->prepare('SELECT * FROM books WHERE title LIKE ? OR author LIKE ?');
    if ($stmt) {
        $likeQuery = '%' . $query . '%';
        $stmt->bind_param('ss', $likeQuery, $likeQuery);
        $stmt->execute();
        $result = $stmt->get_result();
        $searchResults = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    } else {
        echo "Failed to prepare the SQL statement.";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Search Results</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="search_books.php">Search Books</a></li>
            <li><a href="add_book.php">Add Book</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <div class="container">
        <h1>Search Results</h1>
        <ul id="results">
            <?php
            if (!empty($searchResults)) {
                foreach ($searchResults as $book) {
                    echo "<li><a href='" . htmlspecialchars($book['file_path']) . "' target='_blank'>" . htmlspecialchars($book['title']) . " by " . htmlspecialchars($book['author']) . "</a></li>";
                }
            } else {
                echo "<li>No books found.</li>";
            }
            ?>
        </ul>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const results = document.getElementById('results');
            if (results.children.length > 1) {
                results.innerHTML = '';
                <?php foreach ($searchResults as $book): ?>
                    const li = document.createElement('li');
                    const link = document.createElement('a');
                    link.href = "<?php echo htmlspecialchars($book['file_path']); ?>";
                    link.target = "_blank";
                    link.textContent = "<?php echo htmlspecialchars($book['title']); ?> by <?php echo htmlspecialchars($book['author']); ?>";
                    li.appendChild(link);
                    results.appendChild(li);
                <?php endforeach; ?>
            }
        });
    </script>
</body>
</html>
