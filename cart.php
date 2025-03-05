<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cartItems = $_SESSION['cart'];

// Update quantity
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_quantity'])) {
    $id = $_POST['id'];
    $quantity = max(1, (int)$_POST['quantity']);
    
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $id) {
            $item['quantity'] = $quantity;
            break;
        }
    }
    header("Location: cart.php");
    exit;
}

// delet item
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_item'])) {
    $id = $_POST['id'];
    $_SESSION['cart'] = array_filter($_SESSION['cart'], fn($item) => $item['id'] != $id);
    header("Location: cart.php");
    exit;
}

// plus total
function calculateTotal($cart) {
    return array_reduce($cart, fn($total, $item) => $total + $item['price'] * $item['quantity'], 0);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<?php include"navbar.php"?>
<div class="container mt-5">
    <h1 class="text-center">Shopping Cart</h1>

    <?php if (empty($cartItems)) : ?>
        <div class="alert alert-warning text-center">Your cart is empty! <a href="index.php">Continue Shopping</a></div>
    <?php else : ?>
        <table class="table table-bordered text-center">
            <thead class="bg-secondary text-light">
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item) : ?>
                    <tr>
                        <td>
                            <img src="<?= $item['image']; ?>" alt="<?= $item['title']; ?>" style="width: 50px;"> 
                           
                        </td>
                        <td>$<?= number_format($item['price'], 2); ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="id" value="<?= $item['id']; ?>">
                                <input type="number" name="quantity" value="<?= $item['quantity']; ?>" min="1">
                                <button type="submit" name="update_quantity" class="btn btn-sm btn-primary">Update</button>
                            </form>
                        </td>
                        <td>$<?= number_format($item['price'] * $item['quantity'], 2); ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="id" value="<?= $item['id']; ?>">
                                <button type="submit" name="remove_item" class="btn btn-sm btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="text-end">
            <h4>Total: $<?= number_format(calculateTotal($cartItems), 2); ?></h4>
            <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
