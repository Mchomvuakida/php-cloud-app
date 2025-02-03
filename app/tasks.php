<?php
session_start();
include 'db.php';

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle task creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_task'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];  // Assign task to the logged-in user

    $stmt = $conn->prepare("INSERT INTO tasks (title, description, user_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $title, $description, $user_id);
    $stmt->execute();
    echo "Task created successfully!";
}

// Handle task deletion (admin only)
if (isset($_GET['delete_task']) && $_SESSION['role'] === 'admin') {
    $id = $_GET['delete_task'];
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo "Task deleted successfully!";
}

// Fetch tasks
if ($_SESSION['role'] === 'admin') {
    // Admin can see all tasks
    $tasks = $conn->query("SELECT tasks.*, users.username FROM tasks JOIN users ON tasks.user_id = users.id");
} else {
    // Regular users can only see their own tasks
    $user_id = $_SESSION['user_id'];
    $tasks = $conn->query("SELECT tasks.*, users.username FROM tasks JOIN users ON tasks.user_id = users.id WHERE tasks.user_id = $user_id");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Task Management</title>
    <link rel="stylesheet" href="styles.css"> <!-- Add CSS for styling -->
</head>
<body>
    <h1>Task Management</h1>
    <form method="POST">
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <button type="submit" name="create_task">Create Task</button>
    </form>

    <h2>Task List</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Assigned To</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $tasks->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['title'] ?></td>
            <td><?= $row['description'] ?></td>
            <td><?= $row['username'] ?></td>
            <td>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="?delete_task=<?= $row['id'] ?>">Delete</a>
                <?php else: ?>
                <span>No action</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>