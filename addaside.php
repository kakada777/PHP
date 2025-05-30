<?php
// Include database connection file
include 'database/db.php'; // Ensure this file initializes $conn properly

define("HOST", "127.0.0.1");
define("USER", "your_user");
define("PWD", "your_password");
define("DB", "your_db_name");

try {
    // Establish PDO Connection
    $conn = new PDO("mysql:host=" . HOST . ";dbname=" . DB, USER, PWD);
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle form submission
if (isset($_POST['submit'])) {
    // Sanitize and validate input
    $title = htmlspecialchars(trim($_POST['title']));
    $des = htmlspecialchars(trim($_POST['des']));

    // Ensure fields are not empty
    if (empty($title) || empty($des)) {
        echo "<div class='alert alert-danger text-center'>All fields are required!</div>";
    } else {
        // Handle Image Upload
        if (isset($_FILES['pimg']) && $_FILES['pimg']['error'] === UPLOAD_ERR_OK) {
            // Define upload directory
            $upload_dir = __DIR__ . "/../images/";

            // Ensure the uploads directory exists
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Sanitize and create a unique image filename
            $image = basename($_FILES['pimg']['name']);
            $imageid = uniqid() . "_" . $image;
            $image_path = $upload_dir . $imageid;

            // Move uploaded file to uploads folder
            if (move_uploaded_file($_FILES['pimg']['tmp_name'], $image_path)) {
                // Insert data into the database using PDO
                $sql = "INSERT INTO aside (title, des, image) VALUES (:title, :des, :image)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':des', $des);
                $stmt->bindParam(':image', $imageid);

                if ($stmt->execute()) {
                    echo "<div class='alert alert-success text-center'>Product added successfully!</div>";
                } else {
                    echo "<div class='alert alert-danger text-center'>Error: Unable to add product</div>";
                }
            } else {
                echo "<div class='alert alert-danger text-center'>Image upload failed!</div>";
            }
        } else {
            echo "<div class='alert alert-danger text-center'>File upload failed or no file selected.</div>";
        }
    }
}

// Fetch Data from Database
$sql = "SELECT * FROM aside";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
 include 'head.php';
 include 'navbar.php';
?>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4 class="text-center">Add Aside</h4>
        </div>
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <label for="title">Product Name</label>
                        <input type="text" name="title" placeholder="Enter Product Name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="des">Description</label>
                        <textarea rows="3" name="des" placeholder="Enter Description" class="form-control" required></textarea>
                    </div>
                        
                    <div class="col-md-6 mt-3">
                        <label for="pimg">Upload Product Image</label>
                        <input type="file" name="pimg" class="form-control-file" required>
                    </div>
                    <div class="col-md-12 mt-3 text-center">
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Display Products -->
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4 class="text-center">View Aside</h4>
        </div>
        <div class="card-body">
            <table class="table table-responsive table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Aside Image</th>
                        <th>Aside Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result) : ?>
                        <?php foreach ($result as $row) : ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id']) ?></td>
                                <td><?= htmlspecialchars($row['title']) ?></td>
                                <td><img src="../images/<?= htmlspecialchars($row['image']) ?>" class="img-thumbnail" height="50px" width="50px"></td>
                                <td>
                                    <div class="product-description" id="desc-<?= $row['id'] ?>">
                                        <?= htmlspecialchars($row['des']) ?>
                                    </div>
                                    <button class="btn btn-info btn-sm mt-2" onclick="toggleDescription(<?= $row['id'] ?>)">Show Description</button>
                                </td>
                                <td>
                                    <a href="/projectlab2/admin/editaside.php?id=<?= $row['id'] ?>" class="badge bg-primary">Edit</a>
                                    <a href="./aside/deleteaside.php?id=<?= $row['id'] ?>" class="badge bg-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center">No records found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap JS (Optional) -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
    function toggleDescription(productId) {
        var description = document.getElementById("desc-" + productId);
        var button = description.nextElementSibling;

        if (description.style.whiteSpace === "nowrap") {
            description.style.whiteSpace = "normal";
            button.innerText = "Hide Description";
        } else {
            description.style.whiteSpace = "nowrap";
            button.innerText = "Show Description";
        }
    }
</script>

</body>
</html>

<?php
// Close PDO connection
$conn = null;
?>
