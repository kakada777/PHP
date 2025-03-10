<?php
// Include database connection
require_once 'database/db.php'; // Ensure this file initializes $conn properly

try {
    // Establish PDO connection
    $dsn = "mysql:host=127.0.0.1;dbname=ecom_db";
    $conn = new PDO($dsn, "root", "root");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exception handling

    // Fetch the aside data based on the ID passed in the URL
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM aside WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $aside = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$aside) {
            echo "<script>alert('Aside not found.'); window.location = 'index.php?p=viewaside';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Invalid ID.'); window.location = 'index.php?p=viewaside';</script>";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Handle form submission to update the aside data
        $title = $_POST['title'];
        $description = $_POST['description'];
        $image = $_FILES['image']['name'];

        // If a new image is uploaded, handle the image upload
        if (!empty($image)) {
            // Get the current image file path to delete the old image
            $currentImage = $aside['image'];
            $imagePath = "../images/" . $currentImage;

            // Check if the old image exists and delete it
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            // Upload the new image
            $targetDir = "../images/";
            $targetFile = $targetDir . basename($image);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Check if the file is a valid image
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                    echo "The file " . htmlspecialchars(basename($image)) . " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                    exit;
                }
            } else {
                echo "File is not an image.";
                exit;
            }
        } else {
            // If no new image, keep the old image
            $image = $aside['image'];
        }

        // Update the aside record in the database
        $updateSql = "UPDATE aside SET title = :title, des = :description, image = :image WHERE id = :id";
        $stmt = $conn->prepare($updateSql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        echo "<script>alert('Aside updated successfully.'); window.location = 'index.php?p=viewaside';</script>";
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Aside</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <h3 class="text-center">Edit Aside</h3>
    <form action="editaside.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($aside['title']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required><?php echo htmlspecialchars($aside['des']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <div>
                <img src="../images/<?php echo htmlspecialchars($aside['image']); ?>" class="img-thumbnail" height="100px" width="100px">
            </div>
            <input type="file" class="form-control" id="image" name="image">
            <small class="form-text text-muted">Leave empty if you do not want to change the image.</small>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

</body>
</html>

<?php
// No need to explicitly close the PDO connection. It closes automatically when the script ends.
?>
