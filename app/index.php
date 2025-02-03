<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>
    <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h1>
    <p>Your role is: <?= htmlspecialchars($_SESSION['role']) ?></p>
    <a href="logout.php">Logout</a>

    <h2>Menu</h2>
    <ul>
        <?php if ($_SESSION['role'] === 'admin'): ?>
        <li><a href="users.php">User Management</a></li>
        <?php endif; ?>
        <li><a href="tasks.php">Task Management</a></li>
        <li><a href="comments.php">Comment System</a></li>
        <li><a href="upload.php">File Upload</a></li>
    </ul>
</body>
</html>