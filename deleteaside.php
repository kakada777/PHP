<?php
define("HOST", "127.0.0.1");
define("USER", "root");
define("PWD", "root");
define("DB", "ecom_db");

try {
    // Establish PDO connection
    $dsn = "mysql:host=" . HOST . ";dbname=" . DB;
    $conn = new PDO($dsn, USER, PWD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exception handling for errors

    // Validate 'id' parameter
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        echo "<script>alert('Invalid aside ID'); window.location = 'index.php?p=viewaside';</script>";
        exit;
    }

    // Get the ID safely
    $id = (int)$_GET['id'];

    // Fetch the aside image filename before deletionqw
    $stmt = $conn->prepare("SELECT image FROM aside WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $image = $stmt->fetchColumn();

    if ($image) {
        $imagePath = "../images/" . $image;
        if (file_exists($imagePath)) {
            unlink($imagePath); // Delete the image file
        }
    }

    // Delete the aside record
    $stmt = $conn->prepare("DELETE FROM aside WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "<script>window.location = 'viewaside.php?p=viewaside';</script>";
    } else {
        echo "<script>alert('Error deleting aside. Please try again later.'); window.location = 'index.php?p=viewaside';</script>";
    }

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
} finally {
    // Close the connection (PDO connection will be closed automatically when the script ends)
}
?>
