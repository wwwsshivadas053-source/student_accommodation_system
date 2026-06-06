<?php
$page_title = "Manage Users - Admin";
$base_path = "../";
include '../config/db.php';
include '../includes/auth_check.php';
restrictAccess(['admin']);
include '../includes/header.php';

$message = "";
$error = "";

// Handle user deletion
if (isset($_GET['delete_id'])) {
    $user_id = (int)$_GET['delete_id'];
    if ($user_id != $_SESSION['user_id']) {
        if ($conn->query("DELETE FROM users WHERE id = $user_id")) {
            $message = "User deleted successfully!";
        } else {
            $error = "Failed to delete user.";
        }
    } else {
        $error = "Cannot delete your own account!";
    }
}

$users = $conn->query("SELECT * FROM users ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-md-3">
        <div class="dashboard-sidebar">
            <h5 class="mb-4">Navigation</h5>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="users.php" class="active">Manage Users</a></li>
                <li><a href="properties.php">Manage Properties</a></li>
                <li><a href="applications.php">Applications</a></li>
                <li><a href="messages.php">Messages</a></li>
            </ul>
        </div>
    </div>

    <div class="col-md-9">
        <h2 class="mb-4">Manage Users</h2>

        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Phone</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td><?php echo $u['id']; ?></td>
                            <td><?php echo htmlspecialchars($u['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($u['email']); ?></td>
                            <td><span class="badge bg-info"><?php echo ucfirst($u['role']); ?></span></td>
                            <td><?php echo htmlspecialchars($u['phone']); ?></td>
                            <td><?php echo date('d M Y', strtotime($u['created_at'])); ?></td>
                            <td>
                                <?php if ($u['id'] != $_SESSION['user_id']): ?>
                                    <a href="?delete_id=<?php echo $u['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
