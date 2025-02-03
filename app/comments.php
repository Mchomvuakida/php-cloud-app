<?php
session_start();
include 'db.php';

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Only allow admin users to create comments
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_comment']) && $_SESSION['role'] === 'admin') {
    $task_id = $_POST['task_id'];
    $user_id = $_SESSION['user_id'];
    $comment = $_POST['comment'];

    $stmt = $conn->prepare("INSERT INTO comments (task_id, user_id, comment) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $task_id, $user_id, $comment);
    $stmt->execute();
    echo "Comment created successfully!";
}

// Handle comment deletion (admin only)
if (isset($_GET['delete_comment']) && $_SESSION['role'] === 'admin') {
    $id = $_GET['delete_comment'];
    $stmt = $conn->prepare("DELETE FROM comments WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo "Comment deleted successfully!";
}

// Fetch comments
$comments = $conn->query("SELECT comments.*, users.username, tasks.title FROM comments JOIN users ON comments.user_id = users.id JOIN tasks ON comments.task_id = tasks.id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Comment System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Comment System</h1>
        <?php if ($_SESSION['role'] === 'admin'): ?>
        <form method="POST">
            <select name="task_id">
                <?php
                $tasks = $conn->query("SELECT * FROM tasks");
                while ($row = $tasks->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                <?php endwhile; ?>
            </select>
            <textarea name="comment" placeholder="Comment" required></textarea>
            <button type="submit" name="create_comment">Add Comment</button>
        </form>
        <?php endif; ?>

        <h2>Comment List</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Task</th>
                    <th>User</th>
                    <th>Comment</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $comments->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['title'] ?></td>
                    <td><?= $row['username'] ?></td>
                    <td><?= $row['comment'] ?></td>
                    <td>
                        <?php if ($_SESSION['role'] === 'admin'): ?>
                        <a href="?delete_comment=<?= $row['id'] ?>">Delete</a>
                        <?php else: ?>
                        <span>No action</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>