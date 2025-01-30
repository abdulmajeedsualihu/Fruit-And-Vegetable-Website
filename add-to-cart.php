<?php
session_start();
include 'config.php';

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$userId = $_SESSION['id'];
$productId = $_POST['id'];

// Insert into cart table
$sql = "INSERT INTO cart (id, product_id, quantity) VALUES (?, ?, 1)";
$stmt = $pdo->prepare($sql);
$success = $stmt->execute([$userId, $productId]);

echo json_encode(['success' => $success]);
?>
