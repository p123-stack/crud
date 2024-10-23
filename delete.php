<?php
// Include the database connection file
global $conn;
require_once "con.php"; // Ensure this file establishes the PDO connection and defines $conn

// Check if 'id' is present in the GET request
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Prepare the delete statement
    $query = "DELETE FROM results WHERE id = :id";

    try {
        // Prepare the statement
        $stmt = $conn->prepare($query);

        // Bind the ID parameter
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to the index page after successful deletion
            header("Location: index.php");
            exit();
        } else {
            echo "Something went wrong. Please try again later.";
        }


    } catch (PDOException $e) {
        // Handle any exceptions
        echo "Error: " . htmlspecialchars($e->getMessage());
    }
} else {
    echo "No ID provided.";
}

