<?php
define("HOST", "127.0.0.1");
define("USER", "root");
define("PWD", "root");
define("DB", "ecom_db");

// Establish MySQLi connection
$conn = new mysqli(HOST, USER, PWD, DB);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

try {
    // Validate 'id' parameter
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        echo "<script>alert('Invalid aside ID'); window.location = 'index.php?p=viewaside';</script>";
        exit;
    }

    // Get the ID safely
    $id = (int)$_GET['id'];

    // Fetch the aside image filename before deletion
    $stmt = $conn->prepare("SELECT image FROM aside WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($image);
    $stmt->fetch();
    $stmt->close();

    if ($image) {
        $imagePath = "../images/" . $image;
        if (file_exists($imagePath)) {
            unlink($imagePath); // Delete the image file
        }
    }

    // Delete the aside record
    $stmt = $conn->prepare("DELETE FROM aside WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "<script>window.location = 'index.php?p=viewaside';</script>";
    } else {
        echo "<script>alert('Error deleting aside. Please try again later.'); window.location = 'index.php?p=viewaside';</script>";
    }

    $stmt->close();

} catch (Exception $e) {
    die("Database error: " . $e->getMessage());
} finally {
    // Close the connection
    $conn->close();
}
?>
