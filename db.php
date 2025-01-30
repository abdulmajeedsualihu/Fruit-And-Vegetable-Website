<?php
// db.php - Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "fruit_veg_delivery";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>