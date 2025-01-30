<?php
// Database connection (replace with your actual database details)
$host = 'localhost'; // Database host
$db = 'fruit_veg_delivery'; // Database name
$user = 'root'; // Database username
$pass = ''; // Database password

// Create a PDO connection to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// Check if the order_id is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the order details from the database
    $sql = "SELECT * FROM orders WHERE id = :id"; // Query with a placeholder for order_id
    $stmt = $pdo->prepare($sql); // Prepare the query
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Bind the parameter correctly
    $stmt->execute(); // Execute the query
    $order = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the result
    if (!$order) {
        echo "Order not found!";
        exit;
    }
} else {
    echo "No order ID provided!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Order</title>
    <link rel="stylesheet" href="styles.css">
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
                <h1>Order #<?= htmlspecialchars($order['id']) ?></h1>
                <div class="user-info">
                    <span>Admin</span>
                    <a href="logout.php" id="logout-btn" class="logout-btn">Logout</a>
                </div>
            </header>

            <!-- Order Details Section -->
            <section class="order-details-section">
                <h2>Order Details</h2>
                <p><strong>Customer ID:</strong> <?= htmlspecialchars($order['id']) ?></p>
                <p><strong>Order Date:</strong> <?= htmlspecialchars($order['order_date']) ?></p>
                <p><strong>Status:</strong> <?= htmlspecialchars($order['status']) ?></p>
                <p><strong>Total Amount:</strong> $<?= number_format($order['total_price'], 2) ?></p>

                <a href="update-status.php?id=<?= $order['id'] ?>" class="btn-update-status">Update Status</a>
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
