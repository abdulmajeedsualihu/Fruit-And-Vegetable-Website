<?php
include 'includes/../db.php';
session_start();

// Initialize cart session if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add item to cart
if (isset($_GET['add'])) {
    $product_id = $_GET['add'];
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]++; // Increase quantity
    } else {
        $_SESSION['cart'][$product_id] = 1; // Add new item
    }
    header("Location: cart.php");
    exit();
}

// Remove item from cart
if (isset($_GET['remove'])) {
    $product_id = $_GET['remove'];
    unset($_SESSION['cart'][$id]);
    header("Location: cart.php");
    exit();
}

// Update cart quantity
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST['quantity'] as $id => $qty) {
        if ($qty > 0) {
            $_SESSION['cart'][$id] = $qty;
        } else {
            unset($_SESSION['cart'][$id]); // Remove if qty is zero
        }
    }
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/../header.php'; ?>
    <div class="container">
        <h1>🛒 Your Cart</h1>
        
        <?php if (empty($_SESSION['cart'])): ?>
            <p>Your cart is empty.</p>
            <a href="index.php" class="btn">Continue Shopping</a>
        <?php else: ?>
            <form method="POST">
                <table>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    $total_price = 0;
                    foreach ($_SESSION['cart'] as $id => $qty):
                        $sql = "SELECT * FROM products WHERE id = $id";
                        $result = $conn->query($sql);
                        if ($row = $result->fetch_assoc()):
                            $subtotal = $row['price'] * $qty;
                            $total_price += $subtotal;
                    ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td>$<?php echo number_format($row['price'], 2); ?></td>
                        <td><input type="number" name="quantity[<?php echo $id; ?>]" value="<?php echo $qty; ?>" min="1"></td>
                        <td>$<?php echo number_format($subtotal, 2); ?></td>
                        <td><a href="cart.php?remove=<?php echo $id; ?>" class="btn">Remove</a></td>
                    </tr>
                    <?php endif; endforeach; ?>
                    <tr>
                        <td colspan="3"><strong>Total:</strong></td>
                        <td><strong>$<?php echo number_format($total_price, 2); ?></strong></td>
                        <td></td>
                    </tr>
                </table>
                <button type="submit" class="btn">Update Cart</button>
            </form>
            <a href="checkout.php" class="btn">Proceed to Checkout</a>
        <?php endif; ?>
    </div>
    <?php include 'includes/../footer.php'; ?>
</body>
</html>
