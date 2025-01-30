<?php
session_start();
include 'db_connection.php'; // Database connection

// Fetch products from the database
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
    <title>Fruit & Veggies Store</title>
    <link rel="stylesheet" href="index.css">
    <script defer src="index.js"></script>
</head>
<body>
    <header>
        <nav>
            <a href="index.php" class="logo">🍏 Fresh Market</a>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="cart.php">🛒 Cart</a></li>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li><a href="logout.php">🚪 Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">🔑 Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Fresh Fruits & Vegetables</h1>
        <div class="product-container">
            <?php foreach ($products as $product): ?>
                <div class="product">
                    <img src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                    <h2><?php echo $product['name']; ?></h2>
                    <p>$<?php echo number_format($product['price'], 2); ?></p>
                    <button class="add-to-cart" data-id="<?php echo $product['id']; ?>">Add to Cart</button>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 Fresh Market. All rights reserved.</p>
    </footer>
</body>
</html>
