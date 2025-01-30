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

// Handle form submissions for updating settings
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update website title
    if (isset($_POST['website_title'])) {
        $new_title = $_POST['website_title'];
        $stmt = $pdo->prepare("UPDATE settings SET value = :value WHERE setting_name = 'website_title'");
        $stmt->bindParam(':value', $new_title);
        $stmt->execute();
    }

    // Change admin password
    if (isset($_POST['change_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Fetch current password from database
        $stmt = $pdo->prepare("SELECT password FROM admin WHERE admin_id = 1");
        $stmt->execute();
        $stored_password = $stmt->fetch(PDO::FETCH_ASSOC)['password'];

        // Check if current password matches stored password
        if (password_verify($current_password, $stored_password)) {
            if ($new_password === $confirm_password) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE admin SET password = :password WHERE admin_id = 1");
                $stmt->bindParam(':password', $hashed_password);
                $stmt->execute();
                $message = "Password updated successfully!";
            } else {
                $error = "New password and confirm password do not match!";
            }
        } else {
            $error = "Current password is incorrect!";
        }
    }
}

// Fetch current settings values
$stmt = $pdo->prepare("SELECT * FROM settings");
$stmt->execute();
$settings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Admin Dashboard</title>
    <link rel="stylesheet" href="settings.css">
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
                <li><a href="reports.php">Reports</a></li>
                <li><a href="settings.php" class="active">Settings</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <!-- Admin Header with Logout -->
            <header class="admin-header">
                <h1>Settings</h1>
                <div class="user-info">
                    <span>Admin</span>
                    <a href="logout.php" id="logout-btn" class="logout-btn">Logout</a>
                </div>
            </header>

            <!-- Settings Form Section -->
            <section class="settings-section">
                <h2>General Settings</h2>

                <!-- Website Title Setting -->
                <form method="POST">
                    <div class="form-group">
                        <label for="website_title">Website Title:</label>
                        <input type="text" name="website_title" id="website_title" value="<?= htmlspecialchars($settings[0]['value']) ?>" required>
                    </div>
                    <button type="submit" class="btn-save">Save Changes</button>
                </form>

                <h2>Change Admin Password</h2>
                <!-- Admin Password Change Form -->
                <form method="POST">
                    <div class="form-group">
                        <label for="current_password">Current Password:</label>
                        <input type="password" name="current_password" id="current_password" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password">New Password:</label>
                        <input type="password" name="new_password" id="new_password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm New Password:</label>
                        <input type="password" name="confirm_password" id="confirm_password" required>
                    </div>
                    <button type="submit" name="change_password" class="btn-save">Change Password</button>
                </form>

                <!-- Display success/error messages -->
                <?php if (isset($message)) { echo "<p class='success'>$message</p>"; } ?>
                <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
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
