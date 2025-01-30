<?php
include 'includes/../db.php';
session_start();

$order = null;

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = trim($_POST['order_id']);

    // Fetch order details
    $sql = "SELECT * FROM orders WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    
    if ($order) {
        // Fetch order items
        $sql_items = "SELECT oi.*, p.name, p.image FROM order_items oi 
                      JOIN products p ON oi.product_id = p.id 
                      WHERE oi.order_id = ?";
        $stmt_items = $conn->prepare($sql_items);
        $stmt_items->bind_param("i", $order_id);
        $stmt_items->execute();
        $items_result = $stmt_items->get_result();
    } else {
        $error = "Order not found! Please check your Order ID.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Your Order</title>
    <link rel="stylesheet" href="tracker.css">
</head>
<body>
    <?php include 'includes/../header.php'; ?>
    <div class="container">
        <h1>📦 Track Your Order</h1>
        <form method="POST">
            <input type="number" name="order_id" placeholder="Enter Order ID" required>
            <button type="submit" class="btn">Track Order</button>
        </form>

        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php elseif ($order): ?>
            <h2>Order Details</h2>
            <p><strong>Order ID:</strong> <?php echo $order['id']; ?></p>
            <p><strong>Status:</strong> <?php echo $order['status']; ?></p>
            <p><strong>Total Price:</strong> $<?php echo number_format($order['total_price'], 2); ?></p>
            <p><strong>Order Date:</strong> <?php echo $order['order_date']; ?></p>

            <h3>📜 Ordered Items</h3>
            <table>
                <tr>
                    <th>Product</th>
                    <th>Image</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
                <?php while ($item = $items_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td><img src="assets/images/<?php echo $item['image']; ?>" width="50"></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                </tr>
                <?php endwhile; ?>
            </table>

            <h3>🚚 Order Progress</h3>
            <div class="progress-bar">
                <div class="step <?php echo ($order['status'] == 'Pending' || $order['status'] == 'Shipped' || $order['status'] == 'Delivered') ? 'active' : ''; ?>">Pending</div>
                <div class="step <?php echo ($order['status'] == 'Shipped' || $order['status'] == 'Delivered') ? 'active' : ''; ?>">Shipped</div>
                <div class="step <?php echo ($order['status'] == 'Delivered') ? 'active' : ''; ?>">Delivered</div>
            </div>
        <?php endif; ?>
    </div>
    <?php include 'includes/../footer.php'; ?>
</body>
</html>
