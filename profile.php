<?php
session_start();
require_once 'db_connection.php';  // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');  // Redirect to login page if not logged in
    exit();
}

// Fetch user data from the database
$user_id = $_SESSION['id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle profile update form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    
    // Update name and email
    if (isset($_POST['update_profile'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];

        // Update user data in the database
        $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':user_id', $id);
        $stmt->execute();

        $success_message = "Profile updated successfully!";
    }

    // Update password
    if (isset($_POST['change_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Verify current password
        if (password_verify($current_password, $user['password'])) {
            if ($new_password == $confirm_password) {
                // Update password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
                $stmt->bindParam(':password', $hashed_password);
                $stmt->bindParam(':user_id', $id);
                $stmt->execute();

                $success_message = "Password updated successfully!";
            } else {
                $errors[] = "New password and confirm password do not match!";
            }
        } else {
            $errors[] = "Current password is incorrect!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account/Profile - User</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <!-- User Navigation Bar -->
    <?php include 'navbar.php'; ?>

    <!-- Main Content for Account/Profile -->
    <div class="container">
        <h1>My Profile</h1>

        <!-- Success or Error Messages -->
        <?php if (isset($success_message)) { echo "<p class='success'>$success_message</p>"; } ?>
        <?php if (!empty($errors)) { foreach ($errors as $error) { echo "<p class='error'>$error</p>"; } } ?>

        <!-- Profile Form -->
        <form method="POST">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" name="name" id="name" value="<?= htmlspecialchars($user['name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <button type="submit" name="update_profile" class="btn-save">Update Profile</button>
        </form>

        <hr>

        <!-- Change Password Form -->
        <h2>Change Password</h2>
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
    </div>

    <script src="script.js"></script>
</body>
</html>
