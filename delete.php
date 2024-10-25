<?php

$conn = require_once "conn.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $query = "DELETE FROM results WHERE id = :id";

    try {
        $stmt = $conn->prepare($query);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            echo "Something went wrong. Please try again later.";
        }


    } catch (PDOException $e) {
        echo "Error: " . htmlspecialchars($e->getMessage());
    }
} else {
    echo "No ID provided.";
}

