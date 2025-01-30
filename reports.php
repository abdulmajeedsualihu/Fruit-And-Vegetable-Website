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

// Fetch total sales
$sales_query = "SELECT SUM(total_price) AS total_sales FROM orders";
$stmt = $pdo->prepare($sales_query);
$stmt->execute();
$total_sales = $stmt->fetch(PDO::FETCH_ASSOC)['total_sales'];

// Fetch total number of orders
$orders_query = "SELECT COUNT(*) AS total_orders FROM orders";
$stmt = $pdo->prepare($orders_query);
$stmt->execute();
$total_orders = $stmt->fetch(PDO::FETCH_ASSOC)['total_orders'];

// Fetch total number of customers
$customers_query = "SELECT COUNT(*) AS total_customers FROM customers";
$stmt = $pdo->prepare($customers_query);
$stmt->execute();
$total_customers = $stmt->fetch(PDO::FETCH_ASSOC)['total_customers'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Admin Dashboard</title>
    <link rel="stylesheet" href="reports.css">
    <link rel="stylesheet" href="dashboard.css">
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
                <li><a href="orders.php">Orders</a></li>
                <li><a href="customers.php">Customers</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="reports.php" class="active">Reports</a></li>
                <li><a href="settings.php">Settings</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <!-- Admin Header with Logout -->
            <header class="admin-header">
                <h1>Reports</h1>
                <div class="user-info">
                    <span>Admin</span>
                    <a href="logout.php" id="logout-btn" class="logout-btn">Logout</a>
                </div>
            </header>

            <!-- Reports Section -->
            <section class="reports-section">
                <h2>Dashboard Reports</h2>
                <div class="reports-cards">
                    <div class="report-card">
                        <h3>Total Sales</h3>
                        <p>$<?= number_format($total_sales, 2) ?></p>
                    </div>
                    <div class="report-card">
                        <h3>Total Orders</h3>
                        <p><?= $total_orders ?></p>
                    </div>
                    <div class="report-card">
                        <h3>Total Customers</h3>
                        <p><?= $total_customers ?></p>
                    </div>
                </div>
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
