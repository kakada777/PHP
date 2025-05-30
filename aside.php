<?php

require_once 'database/db.php'; // Ensure this file initializes $pdo properly

try {
    // Establish PDO connection
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=your_db_name", "your_user", "your_password", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Get selected aside from the URL
$aside = isset($_GET['aside']) ? $_GET['aside'] : '';

// Modify query to filter by aside if selected
$condition = !empty($aside) ? "WHERE aside = :aside" : "";
$sql = "SELECT * FROM aside $condition";

// Prepare the statement
$stmt = $pdo->prepare($sql);

// Bind parameters if needed
if (!empty($aside)) {
    $stmt->bindParam(":aside", $aside, PDO::PARAM_STR);
}

// Execute the query
$stmt->execute();

// Fetch results
$results = $stmt->fetchAll();
?>

<?php include 'navbar.php'; ?>

<div id="carouselExampleDark" class="carousel carousel-dark slide">
  <div class="carousel-indicators">
    <?php
    $i = 0;
    foreach ($results as $row) {
        echo '<button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="' . $i . '" ' . ($i == 0 ? 'class="active" aria-current="true"' : '') . ' aria-label="Slide ' . ($i + 1) . '"></button>';
        $i++;
    }
    ?>
  </div>

  <div class="carousel-inner">
    <?php
    $first = true;
    foreach ($results as $row) {
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
