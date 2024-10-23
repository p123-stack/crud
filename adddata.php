<?php
global $conn;
require_once "conn.php";  // Assuming this file contains the PDO connection

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $grade = $_POST['grade'];
    $marks = $_POST['marks'];

    // Check if all fields are filled
    if (!empty($name) && !empty($grade) && !empty($marks)) {
        try {
            // Prepare an insert statement using named placeholders
            $sql = "INSERT INTO results (name, class, marks) VALUES (:name, :grade, :marks)";
            $stmt = $conn->prepare($sql);

            // Bind values to placeholders
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->bindValue(':grade', $grade, PDO::PARAM_STR);
            $stmt->bindValue(':marks', $marks, PDO::PARAM_INT);  // Assuming 'marks' is an integer

            // Execute the statement
            if ($stmt->execute()) {
                header("Location: index.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Name, Class, and Marks cannot be empty!";
    }
}
?>
