<?php
require_once "../includes/db.php";
require_once "../includes/functions.php";
include "includes/header.php";

if (!isset($_GET["id"])) {
    header("Location: users.php");
    exit;
}

$id = (int)$_GET["id"];
$user = $conn->query("SELECT * FROM users WHERE id=$id")->fetch_assoc();

if (!$user) {
    header("Location: users.php");
    exit;
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name  = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $role  = $_POST["role"];

    if (empty($name) || empty($email)) {
        $error = "Name and email are required.";
    } else {
        $stmt = $conn->prepare("UPDATE users SET name=?, email=?, role=? WHERE id=?");
        $stmt->bind_param("sssi", $name, $email, $role, $id);

        if ($stmt->execute()) {
            $success = "User updated successfully.";
        } else {
            $error = "Update failed.";
        }
    }
}
?>

<h1 class="mb-4">✏️ Edit User</h1>

<?php if ($error): ?>
    <div class="alert alert-danger"><?= $error; ?></div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="alert alert-success"><?= $success; ?></div>
<?php endif; ?>

<form method="POST" class="card p-4 shadow-sm" style="max-width:600px;">
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" value="<?= e($user['name']); ?>" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" value="<?= e($user['email']); ?>" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Role</label>
        <select name="role" class="form-control">
            <option value="admin" <?= $user['role'] == "admin" ? "selected" : ""; ?>>Admin</option>
            <option value="staff" <?= $user['role'] == "staff" ? "selected" : ""; ?>>Staff</option>
        </select>
    </div>

    <button class="btn btn-primary">Update</button>
    <a href="users.php" class="btn btn-secondary">Back</a>
</form>

<?php include "includes/footer.php"; ?>