<?php
// db_config.php

/**
 * Helper class to establish a PostgreSQL database connection using PDO.
 * IMPORTANT: Replace placeholder credentials with your actual PostgreSQL connection details.
 */
class Database {
    // !!! CONFIGURE YOUR DATABASE CONNECTION DETAILS HERE !!!
    private $host = 'localhost';
    private $dbname = 'portfolio_db';
    private $user = 'postgres_user';
    private $password = 'your_strong_password';
    private $port = '5432';
    public $conn;

    /**
     * Establishes and returns a PDO connection object.
     * @return PDO|null The database connection object, or null on failure.
     */
    public function connect() {
        $this->conn = null;
        $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname};user={$this->user};password={$this->password}";

        try {
            $this->conn = new PDO($dsn);
            // Set error mode to exception for better error handling
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $exception) {
            // Displaying connection error is useful for development but should be logged in production.
            echo "<div style='color:red; text-align:center;'>FATAL ERROR: Database connection failed. Please check db_config.php. Error: " . htmlspecialchars($exception->getMessage()) . "</div>";
            return null;
        }
    }
}
// Note: fetchResumeData function is moved to AppModel.php for MVC separation.