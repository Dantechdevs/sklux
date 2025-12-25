<?php
require_once "../includes/db.php";
require_once "../includes/functions.php";
include "includes/header.php";

// Fetch all users
$users = $conn->query("SELECT * FROM users ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC);
?>

<h1 class="mb-4">👥 Users Management</h1>

<div class="mb-3">
    <a href="add_user.php" class="btn btn-success">
        <i class="fas fa-plus"></i> Add New User
    </a>
</div>

<?php if (!empty($users)): ?>
    <table class="table table-bordered table-hover shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= e($user['id']); ?></td>
                    <td><?= e($user['name']); ?></td>
                    <td><?= e($user['email']); ?></td>
                    <td><?= e($user['role']); ?></td>
                    <td><?= e($user['created_at']); ?></td>
                    <td>
                        <a href="edit_user.php?id=<?= $user['id']; ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="delete_user.php?id=<?= $user['id']; ?>" class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure you want to delete this user?');">
                            <i class="fas fa-trash-alt"></i> Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="alert alert-info">
        No users found.
    </div>
<?php endif; ?>

<?php include "includes/footer.php"; ?>