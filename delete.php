<?php
include 'database/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get the image file name to delete the file from the server
    $sql = "SELECT img FROM products WHERE id = $id";
    $result = $conn->query($sql);
    $product = $result->fetch_assoc();
    $img_path = $product['img'];

    $sql = "DELETE FROM products WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        unlink($img_path); // Delete the image from the server
        header("Location: dashbord.php");
    }
}

$conn->close();
?>
