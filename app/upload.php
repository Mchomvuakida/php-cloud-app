<?php
session_start();
include 'db.php';

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Create the uploads directory if it doesn't exist
if (!is_dir('uploads')) {
    mkdir('uploads', 0777, true);
}

// Upload File
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $user_id = $_SESSION['user_id'];
    $filename = basename($_FILES['file']['name']);
    $filepath = 'uploads/' . $filename;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $filepath)) {
        $stmt = $conn->prepare("INSERT INTO files (filename, filepath, user_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $filename, $filepath, $user_id);
        $stmt->execute();
        echo "File uploaded successfully!";
    } else {
        echo "File upload failed!";
    }
}

// Delete File (admin only)
if (isset($_GET['delete_file']) && $_SESSION['role'] === 'admin') {
    $id = $_GET['delete_file'];
    $stmt = $conn->prepare("DELETE FROM files WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo "File deleted successfully!";
}

// Fetch files
$files = $conn->query("SELECT files.*, users.username FROM files JOIN users ON files.user_id = users.id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>File Upload</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>File Upload</h1>
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="file" required>
            <button type="submit">Upload File</button>
        </form>

        <h2>File List</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Filename</th>
                    <th>Uploaded By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $files->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['filename'] ?></td>
                    <td><?= $row['username'] ?></td>
                    <td>
                        <?php if ($_SESSION['role'] === 'admin'): ?>
                        <a href="?delete_file=<?= $row['id'] ?>">Delete</a>
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