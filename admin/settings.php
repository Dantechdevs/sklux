<?php
require_once 'includes/header.php';
require_once '../includes/db.php';

// Fetch settings (only one row expected)
$settings = $conn->query("SELECT * FROM settings LIMIT 1")->fetch_assoc();

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $site_name    = $_POST['site_name'];
    $site_email   = $_POST['site_email'];
    $site_phone   = $_POST['site_phone'];
    $site_address = $_POST['site_address'];
    $currency     = $_POST['currency'];

    $logo = $settings['logo'];

    // Handle logo upload
    if (!empty($_FILES['logo']['name'])) {
        $uploadDir = "../uploads/logo/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $logo = time() . '_' . $_FILES['logo']['name'];
        move_uploaded_file($_FILES['logo']['tmp_name'], $uploadDir . $logo);
    }

    $stmt = $conn->prepare("
        UPDATE settings SET 
            site_name=?, 
            site_email=?, 
            site_phone=?, 
            site_address=?, 
            currency=?, 
            logo=?
        WHERE id=?
    ");

    $stmt->bind_param(
        "ssssssi",
        $site_name,
        $site_email,
        $site_phone,
        $site_address,
        $currency,
        $logo,
        $settings['id']
    );

    $stmt->execute();

    header("Location: settings.php?success=1");
    exit;
}
?>

<div class="container-fluid">
    <h2 class="mb-4">⚙️ System Settings</h2>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Settings updated successfully</div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm w-100">

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Site Name</label>
                <input type="text" name="site_name" value="<?= htmlspecialchars($settings['site_name']); ?>"
                    class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Site Email</label>
                <input type="email" name="site_email" value="<?= htmlspecialchars($settings['site_email']); ?>"
                    class="form-control" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Phone</label>
                <input type="text" name="site_phone" value="<?= htmlspecialchars($settings['site_phone']); ?>"
                    class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Currency</label>
                <select name="currency" class="form-control">
                    <option <?= $settings['currency'] == 'KES' ? 'selected' : '' ?>>KES</option>
                    <option <?= $settings['currency'] == 'USD' ? 'selected' : '' ?>>USD</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label>Site Address</label>
            <textarea name="site_address" class="form-control"
                rows="3"><?= htmlspecialchars($settings['site_address']); ?></textarea>
        </div>

        <div class="mb-3">
            <label>Logo</label><br>
            <?php if ($settings['logo']): ?>
                <img src="../uploads/logo/<?= $settings['logo']; ?>" height="60" class="mb-2"><br>
            <?php endif; ?>
            <input type="file" name="logo" class="form-control">
        </div>

        <button class="btn btn-primary">💾 Save Settings</button>

    </form>
</div>

<?php require_once 'includes/footer.php'; ?>