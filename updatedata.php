<?php
// Start output buffering
ob_start();

// Start PHP code before any HTML output
global $conn;
require_once "con.php";

$id = $_GET['id'] ?? null; // Get the ID from the URL, validate as necessary

// Validate ID
if ($id) {
    // Fetch existing data
    $sql_select = "SELECT * FROM results WHERE id = :id";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bindValue(':id', $id, PDO::PARAM_INT);

    if ($stmt_select->execute()) {
        $row = $stmt_select->fetch(PDO::FETCH_ASSOC); // Use fetch with PDO
        if ($row) {
            // Existing data fetched successfully
            $name = $row['name'];
            $grade = $row['class'];
            $marks = $row['marks'];
        } else {
            echo "No record found.";
            exit();
        }
    } else {
        echo "Error fetching record.";
        exit();
    }

    // Handle form submission for update
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["name"], $_POST["grade"], $_POST["marks"])) {
        $name = $_POST['name'];
        $grade = $_POST['grade'];
        $marks = $_POST['marks'];

        // Prepare the update statement
        $sql_update = "UPDATE results SET `name` = :name, `class` = :grade, `marks` = :marks WHERE id = :id";

        try {
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt_update->bindValue(':grade', $grade, PDO::PARAM_STR);
            $stmt_update->bindValue(':marks', $marks, PDO::PARAM_INT);
            $stmt_update->bindValue(':id', $id, PDO::PARAM_INT);

            if ($stmt_update->execute()) {
                header("Location: index.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
        } catch (PDOException $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
        }
    }
} else {
    echo "No ID provided.";
    exit();
}
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PHP - MYSQL - CRUD</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
                crossorigin="anonymous"></script>
    </head>

    <body>
    <section>
        <h1 style="text-align: center; margin: 50px 0;">Update Data</h1>
        <div class="container">
            <form action="updatedata.php?id=<?php echo htmlspecialchars($id); ?>" method="post">
                <div class="row">
                    <div class="form-group col-lg-4">
                        <label for="name">Student Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>" required>
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="grade">Grade</label>
                        <select name="grade" id="grade" class="form-control" required>
                            <option value="">Select a Grade</option>
                            <option value="grade6" <?php echo $grade === "grade6" ? "selected" : ""; ?>>Grade 6</option>
                            <option value="grade7" <?php echo $grade === "grade7" ? "selected" : ""; ?>>Grade 7</option>
                            <option value="grade8" <?php echo $grade === "grade8" ? "selected" : ""; ?>>Grade 8</option>
                            <option value="grade9" <?php echo $grade === "grade9" ? "selected" : ""; ?>>Grade 9</option>
                            <option value="grade10" <?php echo $grade === "grade10" ? "selected" : ""; ?>>Grade 10</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-3">
                        <label for="marks">Marks</label>
                        <input type="text" name="marks" id="marks" class="form-control" value="<?php echo htmlspecialchars($marks); ?>" required>
                    </div>
                    <div class="form-group col-lg-2" style="display: grid; align-items: flex-end;">
                        <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Update">
                    </div>
                </div>
            </form>
        </div>
    </section>
    </body>
    </html>

<?php
// Flush output buffer
ob_end_flush();
