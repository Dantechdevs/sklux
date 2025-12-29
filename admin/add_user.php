<?php
require_once "../includes/db.php";
require_once "../includes/functions.php";
include "includes/header.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name  = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $role  = $_POST["role"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    if (empty($name) || empty($email) || empty($_POST["password"])) {
        $error = "All fields are required.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $password, $role);

        if ($stmt->execute()) {
            $success = "User added successfully.";
        } else {
            $error = "Error adding user.";
        }
    }
}
?>

<h1 class="mb-4">➕ Add New User</h1>

<?php if ($error): ?>
    <div class="alert alert-danger"><?= $error; ?></div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="alert alert-success"><?= $success; ?></div>
<?php endif; ?>

<form method="POST" class="card p-4 shadow-sm" class="max-width:600px;">
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Role</label>
        <select name="role" class="form-control">
            <option value="admin">Admin</option>
            <option value="staff">Staff</option>
        </select>
    </div>

    <button class="btn btn-success">Save User</button>
    <a href="users.php" class="btn btn-secondary">Back</a>
</form>

<?php include "includes/footer.php"; ?>