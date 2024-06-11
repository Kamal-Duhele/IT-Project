<?php
class Database {
    private static $instance = null;
    private $conn;

    private $host = 'localhost';
    private $db = 'library';
    private $user = 'root'; // Adjust your database username
    private $pass = ''; // Adjust your database password

    private function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        // Create tables if they do not exist
        $this->createTables();
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }

    private function createTables() {
        // Create users table
        $usersTableQuery = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL UNIQUE,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        )";

        // Create books table
        $booksTableQuery = "CREATE TABLE IF NOT EXISTS books (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            author VARCHAR(255) NOT NULL,
            file_path VARCHAR(255) NOT NULL
        )";

        // Create password_resets table
        $passwordResetsTableQuery = "CREATE TABLE IF NOT EXISTS password_resets (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL,
            token VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        if ($this->conn->query($usersTableQuery) !== TRUE) {
            die("Error creating users table: " . $this->conn->error);
        }

        if ($this->conn->query($booksTableQuery) !== TRUE) {
            die("Error creating books table: " . $this->conn->error);
        }

        if ($this->conn->query($passwordResetsTableQuery) !== TRUE) {
            die("Error creating password_resets table: " . $this->conn->error);
        }
    }
}
?>
