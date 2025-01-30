<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Fruit & Veg Delivery</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Admin Sidebar Navigation -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <h2>Admin Dashboard</h2>
            </div>
            <ul class="sidebar-nav">
                <li><a href="#">Dashboard</a></li>
                <li><a href="orders.php">Orders</a></li>
                <li><a href="#">Customers</a></li>
                <li><a href="#">Products</a></li>
                <li><a href="#">Reports</a></li>
                <li><a href="#">Settings</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <!-- Admin Header with Logout -->
            <header class="admin-header">
                <h1>Welcome, Admin!</h1>
                <div class="user-info">
                    <span>Admin</span>
                    <a href="logout.php" id="logout-btn" class="logout-btn">Logout</a>
                </div>
            </header>

            <!-- Admin Dashboard Overview -->
            <section class="overview-cards">
                <div class="card">
                    <h2>Total Orders</h2>
                    <p>120</p>
                </div>
                <div class="card">
                    <h2>Total Revenue</h2>
                    <p>$5000</p>
                </div>
                <div class="card">
                    <h2>Pending Deliveries</h2>
                    <p>15</p>
                </div>
            </section>

            <section class="chart">
                <h2>Sales Overview</h2>
                <div id="sales-chart">[Chart Placeholder]</div>
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
