<?php
// Fetch order details
include('db.php');

$order_id = $_GET['order_id'];
$stmt = $pdo->prepare("SELECT * FROM orders WHERE order_id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch();

if ($order) {
    // Fetch order items
    $stmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
    $stmt->execute([$order_id]);
    $order_items = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="container">
        <h2>Order Confirmation</h2>
        <p>Thank you for your order!</p>

        <h3>Order #<?php echo $order['order_id']; ?></h3>
        <p>Order placed on: <?php echo $order['order_date']; ?></p>
        <p>Shipping Address: <?php echo $order['address']; ?></p>

        <h4>Order Details</h4>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order_items as $item): ?>
                    <tr>
                        <td><?php echo $item['product_name']; ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td><?php echo $item['price']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p>Total Amount: $<?php echo $order['total_amount']; ?></p>
    </div>

</body>
</html>
