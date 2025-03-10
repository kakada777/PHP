<?php
session_start(); // Start the session to manage the cart

include 'database/db.php';
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add product to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $product = array_filter($result->fetch_all(MYSQLI_ASSOC), fn($p) => $p['id'] == $product_id);

    if ($product) {
        $product = array_values($product)[0];
        $exists = false;

        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $product_id) {
                $item['quantity'] += 1;
                $exists = true;
                break;
            }
        }

        if (!$exists) {
            $product['quantity'] = 1;
            $_SESSION['cart'][] = $product;
        }
    }
    header("Location: Shoes.php");
    exit();
}

// Remove product from cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_id'])) {
    $_SESSION['cart'] = array_values(array_filter($_SESSION['cart'], fn($item) => $item['id'] != $_POST['remove_id']));
    header("Location: Shoes.php");
    exit();
}

// Calculate total function
function calculateTotal() {
    return array_reduce($_SESSION['cart'], fn($total, $item) => $total + $item['price'] * $item['quantity'], 0);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trendy Products</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
<?php 
include 'navbar.php'; 
// include 'aside.php';
?>

<div class="container mt-5">
    <h2 class="text-center">Trendy Products</h2>
    <div class="row">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="<?= htmlspecialchars($row['img']) ?>" class="card-img-top" style="height: 200px; object-fit: contain;" alt="Product Image">
                    <div class="card-body text-center">
                        <h6><?= htmlspecialchars($row['name']) ?></h6>
                        <h6>$<?= number_format($row['price'], 2) ?></h6>
                        <form method="POST">
                            <input type="hidden" name="product_id" value="<?= $row['id']; ?>">
                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>   
    </div>
</div>

</body>
</html>
