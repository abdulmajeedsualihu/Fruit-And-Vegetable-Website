<?php
// Database connection (replace with your connection details)
$host = 'localhost';
$db = 'fruit_veg_delivery';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// Check if an order_id is passed in the URL
if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    // Fetch the order details
    $sql = "SELECT * FROM orders WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':order_id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        // If order doesn't exist
        echo "Order not found!";
        exit;
    }
} else {
    echo "No order ID provided!";
    exit;
}

// Handle form submission to update the order status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
    $new_status = $_POST['status'];

    // Update the order status in the database
    $update_sql = "UPDATE orders SET order_status = :status WHERE id = :id";
    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->bindParam(':status', $new_status, PDO::PARAM_STR);
    $update_stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($update_stmt->execute()) {
        echo "<p>Status updated successfully!</p>";
        header("Location: orders.php"); // Redirect back to orders page after update
        exit;
    } else {
        echo "<p>Failed to update status!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order Status</title>
    <link rel="stylesheet" href="update-status.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar Navigation -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <h2>Admin Dashboard</h2>
            </div>
            <ul class="sidebar-nav">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="orders.php" class="active">Orders</a></li>
                <li><a href="customers.php">Customers</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="reports.php">Reports</a></li>
                <li><a href="settings.php">Settings</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <!-- Admin Header with Logout -->
            <header class="admin-header">
                <h1>Update Order Status</h1>
                <div class="user-info">
                    <span>Admin</span>
                    <a href="logout.php" id="logout-btn" class="logout-btn">Logout</a>
                </div>
            </header>

            <!-- Order Status Update Form -->
            <section class="orders-section">
                <h2>Update Status for Order #<?= htmlspecialchars($order['order_id']) ?></h2>

                <form action="update-status.php?order_id=<?= $order['order_id'] ?>" method="POST">
                    <label for="status">Order Status:</label>
                    <select name="status" id="status">
                        <option value="Pending" <?= $order['order_status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="Shipped" <?= $order['order_status'] == 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                        <option value="Delivered" <?= $order['order_status'] == 'Delivered' ? 'selected' : '' ?>>Delivered</option>
                    </select>

                    <button type="submit" class="btn-update-status">Update Status</button>
                </form>
            </section>

            <!-- Admin Footer -->
            <footer class="footer">
                <p>&copy; 2025 Fruit & Veg Delivery. All Rights Reserved.</p>
                <p>Designed by YourCompanyName</p>
            </footer>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>
