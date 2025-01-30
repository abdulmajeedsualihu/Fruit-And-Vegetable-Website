<?php
// Start the session to check for logged-in users and cart data
session_start();

// Include database connection
include('../db.php');

// Check if user is logged in (this is optional if your website has user authentication)
if (!isset($_SESSION['id'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit();
}

// Initialize cart variable
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// If the cart is empty, redirect to home page or display a message
if (empty($cart)) {
    echo "<script>alert('Your cart is empty!'); window.location.href='index.php';</script>";
    exit();
}

// Handle form submission (for checkout)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the user details from the form
    $user_id = $_SESSION['id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $total_amount = $_POST['total_amount'];  // Calculate this based on cart items

    // Insert order into the database
    try {
        $pdo->beginTransaction(); // Start transaction to ensure consistency

        // Insert order details into the orders table
        $stmt = $pdo->prepare("INSERT INTO orders (id, name, address, phone, total_amount) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$id, $name, $address, $phone, $total_amount]);

        // Get the last inserted order ID
        $order_id = $pdo->lastInsertId();

        // Insert order items into the order_items table
        foreach ($cart as $item) {
            $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            $stmt->execute([$order_id, $item['product_id'], $item['quantity'], $item['price']]);
        }

        // Commit the transaction
        $pdo->commit();

        // Clear the cart after order is placed
        unset($_SESSION['cart']);

        // Redirect to a success page or order summary
        header("Location: order-success.php?order_id=$order_id");
        exit();

    } catch (Exception $e) {
        // If there is an error, roll back the transaction
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Food Delivery</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="container">
        <h2>Checkout</h2>

        <!-- Cart details -->
        <div class="cart-details">
            <h3>Your Cart</h3>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_amount = 0;
                    foreach ($cart as $item) {
                        echo "<tr>
                                <td>{$item['product_name']}</td>
                                <td>{$item['quantity']}</td>
                                <td>{$item['price']}</td>
                              </tr>";
                        $total_amount += $item['price'] * $item['quantity'];
                    }
                    ?>
                </tbody>
            </table>
            <p>Total: $<?php echo number_format($total_amount, 2); ?></p>
        </div>

        <!-- Checkout form -->
        <form method="POST" action="checkout.php">
            <h3>Billing Details</h3>
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="address">Shipping Address</label>
                <textarea id="address" name="address" required></textarea>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" required>
            </div>

            <input type="hidden" name="total_amount" value="<?php echo $total_amount; ?>">

            <button type="submit">Place Order</button>
        </form>
    </div>

</body>
</html>
