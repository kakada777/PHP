<?php
include 'database/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $img = $_FILES['img']['name'];
    $targetDir = "uploads/";
    
    // Ensure the uploads directory exists
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $targetFile = $targetDir . basename($img);

    // Check if there are any file upload errors
    if ($_FILES['img']['error'] === UPLOAD_ERR_OK) {
        if (move_uploaded_file($_FILES['img']['tmp_name'], $targetFile)) {
            $sql = "INSERT INTO products (name, price, img) VALUES ('$name', '$price', '$targetFile')";
            if ($conn->query($sql) === TRUE) {
                header("Location: dashbord.php");
                exit;
            } else {
                echo "Database Error: " . $conn->error;
            }
        } else {
            echo "Failed to move uploaded file.";
        }
    } else {
        echo "File upload error: " . $_FILES['img']['error'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php
include 'navbar.php';
?>
    
    
    <div class="container">
    <h1>Add New Product</h1>
        <form method="POST" enctype="multipart/form-data">
            Name: <input class="form-control" type="text" name="name" required><br>
            Price: <input class="form-control" type="text" name="price" required><br>
            Image: <input class="form-control" type="file" name="img" required><br>
            <button type="submit" class="btn btn-primary">Add Product</button>
        </form> 
        <a href="dashbord.php" class="btn btn-danger">Back to Products</a>
    </div>

</body>
</html>

<?php $conn->close(); ?>
