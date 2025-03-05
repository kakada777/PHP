<?php
session_start();

// Fetch products from FakeStore API
$apiUrl = "https://fakestoreapi.com/products";
$products = json_decode(file_get_contents($apiUrl), true);

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add product to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $product = array_filter($products, fn($p) => $p['id'] == $product_id);
    
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


    <?php include "head.php"; ?>

<body>
<?php include "navbar.php"; ?>
<?php include "scroll.php"; ?>
    <div class="container mt-5">
        <h2 class="text-center">Trendy Products</h2>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="<?= htmlspecialchars($product['image']) ?>" class="card-img-top" style="height: 200px; object-fit: contain;" alt="Product Image">
                        <div class="card-body text-center">
                            <h6><?= htmlspecialchars($product['title']) ?></h6>
                            <h6>$<?= number_format($product['price'], 2) ?></h6>
                            <form method="POST">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <button type="submit" class="btn btn-primary">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>


