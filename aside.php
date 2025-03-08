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
$condition = !empty($aside) ? "WHERE aside = ?" : "";
$sql = "SELECT * FROM aside $condition";

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
?>

<?php include 'navbar.php'; ?>

<div id="carouselExampleDark" class="carousel carousel-dark slide">
  <div class="carousel-indicators">
    <?php
    $i = 0;
    while ($row = $result->fetch_assoc()) {
        echo '<button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="' . $i . '" ' . ($i == 0 ? 'class="active" aria-current="true"' : '') . ' aria-label="Slide ' . ($i + 1) . '"></button>';
        $i++;
    }
    // Reset result pointer
    $result->data_seek(0);
    ?>
  </div>

  <div class="carousel-inner">
    <?php
    $first = true;
    while ($row = $result->fetch_assoc()) {
    ?>
        <div class="carousel-item <?php echo $first ? 'active' : ''; ?>" data-bs-interval="10000">
            <img src="../images/<?php echo htmlspecialchars($row['image']); ?>" class="d-block w-100">
            <div class="carousel-caption d-none d-md-block">
                <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                <p><?php echo htmlspecialchars($row['des']); ?></p>
            </div>
        </div>
    <?php
        $first = false;
    }
    ?>
  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<?php
// Close the connection
$stmt->close();
$conn->close();
?>
