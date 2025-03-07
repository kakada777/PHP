<?php
// Include database connection
require_once 'database/db.php'; // Ensure this file initializes $conn properly

// Establish MySQLi connection
$conn = new mysqli("127.0.0.1", "root", "root", "ecom_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get selected aside from the URL
$aside = isset($_GET['aside']) ? $_GET['aside'] : '';

// Modify query to filter by aside if selected
$condition = !empty($aside) ? "aside = ?" : "";
$params = !empty($aside) ? [$aside] : [];

// Create the SQL query
$sql = "SELECT * FROM aside";
if ($condition) {
    $sql .= " WHERE $condition";
}

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind parameters if needed
if (!empty($aside)) {
    $stmt->bind_param("s", $aside); // "s" for string
}

// Execute the query
$stmt->execute();

// Get the result
$result = $stmt->get_result();
$num = $result->num_rows;
?>
<?php include 'navbar.php'; ?>

<aside id="fh5co-hero" class="js-fullheight">
    <div class="flexslider js-fullheight">
        <ul class="slides">
            <?php
            while ($row = $result->fetch_assoc()) {
            ?>
                <li>
                    <img src="../images/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                    <div class="overlay-gradient"></div>
                    <div class="container">
                        <div class="col-md-6 col-md-offset-3 col-md-pull-3 js-fullheight slider-text">
                            <div class="slider-text-inner">
                                <div class="desc">
                                    <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                                    <p><?php echo htmlspecialchars($row['des']); ?></p>
                                    <p><a href="index.php?p=product" class="btn btn-primary btn-outline btn-lg">SHOP</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            <?php
            }
            ?>
        </ul>
    </div>
</aside>

<?php
// Close the connection
$stmt->close();
$conn->close();
?>
