<?php

// Define database credentials (consider using environment variables for sensitive data)
define('DB_SERVER', 'mysql');         // Database server (e.g., 'localhost')
define('DB_USERNAME', 'youruser');    // Your database username
define('DB_PASSWORD', 'yourpassword'); // Your database password
define('DB_NAME', 'yourdatabase');    // Your database name

// Set the Data Source Name (DSN)
$dsn = "mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8mb4";

// PDO options to handle errors and set fetch mode
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Error handling as exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch data as associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                 // Disable emulation of prepared statements for better security
];

try {
    // Create a new PDO instance
    $conn = new PDO($dsn, DB_USERNAME, DB_PASSWORD, $options);
} catch (PDOException $e) {
    // Handle connection error (consider logging the error instead)
    error_log("Database connection error: " . $e->getMessage());
    die("ERROR: Could not connect to the database.");
}

// Optional: Close the connection when done
// $conn = null;
