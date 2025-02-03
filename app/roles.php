<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $role = $_POST['role'];
    $sql = "INSERT INTO roles (role) VALUES ('$role')";
    $conn->query($sql);
}

$result = $conn->query("SELECT * FROM roles");

while ($row = $result->fetch_assoc()) {
    echo $row["id"] . " - " . $row["role"] . "<br>";
}
?>
<form method="POST">
    <input type="text" name="role" placeholder="Role (Admin/User)" required>
    <button type="submit">Add Role</button>
</form>
