<?php
include 'database/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id = $id";
    $result = $conn->query($sql);
    $product = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $img = $_FILES['img']['name'];
    
    if ($img) {
        $target = "uploads/" . basename($img);
        move_uploaded_file($_FILES['img']['tmp_name'], $target);
        $sql = "UPDATE products SET name = '$name', price = '$price', img = '$target' WHERE id = $id";
    } else {
        $sql = "UPDATE products SET name = '$name', price = '$price' WHERE id = $id";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: dashbord.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
</head>
<body>

<h1>Edit Product</h1>

<form method="POST" enctype="multipart/form-data">
    Name: <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required><br>
    Price: <input type="text" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required><br>
    Image: <input type="file" name="img"><br>
    <button type="submit">Update Product</button>
</form>

</body>
</html>

<?php $conn->close(); ?>