<?php
require_once 'includes/header.php';
require_once '../includes/db.php';

// Fetch products
$query = "SELECT * FROM products ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Products</h2>
        <a href="add-product.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Product
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $row['id']; ?></td>
                                <td>
                                    <?php if (!empty($row['image'])): ?>
                                        <img src="../uploads/products/<?= $row['image']; ?>" width="50" height="50" class="rounded"
                                            style="object-fit: cover;">
                                    <?php else: ?>
                                        <span class="text-muted">No Image</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($row['name']); ?></td>
                                <td>$<?= number_format($row['price'], 2); ?></td>
                                <td>
                                    <?php if ($row['stock'] > 0): ?>
                                        <span class="badge bg-success"><?= $row['stock']; ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Out</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('M d, Y', strtotime($row['created_at'])); ?></td>
                                <td class="text-end">
                                    <a href="edit-product.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="delete-product.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this product?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                No products found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>