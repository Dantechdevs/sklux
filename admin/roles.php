<?php require_once 'includes/header.php'; ?>

<div class="container-fluid">
    <h2 class="mb-4">User Roles</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <p class="text-muted">
                Roles are defined at the database level using an ENUM field.
            </p>

            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Role</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="badge bg-danger">Admin</span></td>
                        <td>Full access to the admin panel</td>
                    </tr>
                    <tr>
                        <td><span class="badge bg-secondary">User</span></td>
                        <td>Limited access (frontend only)</td>
                    </tr>
                </tbody>
            </table>

            <div class="alert alert-info mt-3">
                To add more roles, the database ENUM must be updated.
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>