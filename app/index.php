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
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container home-container">
        <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h1>
        <p>Your role is: <?= htmlspecialchars($_SESSION['role']) ?></p>
        <a href="logout.php" class="logout">Logout</a>


        <h2>Menu</h2>
        <ul>
            <?php if ($_SESSION['role'] === 'admin'): ?>
            <li><a href="users.php">User Management</a></li>
            <li><a href="tasks.php">Task Management</a></li>
            <li><a href="comments.php">Comment System</a></li>
            <li><a href="upload.php">File Upload</a></li>
            <?php else: ?>
            <li><a href="tasks.php">View Tasks</a></li>
            <li><a href="comments.php">View Comments</a></li>
            <li><a href="upload.php">Upload Files</a></li>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>