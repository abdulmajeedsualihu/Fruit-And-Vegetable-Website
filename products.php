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

// Fetch all products from the database
$sql = "SELECT * FROM products";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Admin Dashboard</title>
    <link rel="stylesheet" href="products.css">
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
                <li><a href="products.php" class="active">Products</a></li>
                <li><a href="reports.php">Reports</a></li>
                <li><a href="settings.php">Settings</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <!-- Admin Header with Logout -->
            <header class="admin-header">
                <h1>Products</h1>
                <div class="user-info">
                    <span>Admin</span>
                    <a href="logout.php" id="logout-btn" class="logout-btn">Logout</a>
                </div>
            </header>

            <!-- Products Table Section -->
            <section class="products-section">
                <h2>All Products</h2>
                <table class="products-table">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?= htmlspecialchars($product['id']) ?></td>
                                <td><?= htmlspecialchars($product['name']) ?></td>
                                <td><?= htmlspecialchars($product['category']) ?></td>
                                <td>$<?= number_format($product['price'], 2) ?></td>
                                <td>
                                    <a href="edit-product.php?product_id=<?= $product['id'] ?>" class="btn-edit">Edit</a>
                                    <a href="delete-product.php?product_id=<?= $product['id'] ?>" class="btn-delete">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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
