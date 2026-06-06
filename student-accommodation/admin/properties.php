<?php
$page_title = "Manage Properties - Admin";
$base_path = "../";
include '../config/db.php';
include '../includes/auth_check.php';
restrictAccess(['admin']);
include '../includes/header.php';

$message = "";
$error = "";

// Handle property deletion
if (isset($_GET['delete_id'])) {
    $prop_id = (int)$_GET['delete_id'];
    if ($conn->query("DELETE FROM properties WHERE id = $prop_id")) {
        $message = "Property deleted successfully!";
    } else {
        $error = "Failed to delete property.";
    }
}

$properties = $conn->query("SELECT p.*, u.full_name FROM properties p JOIN users u ON p.landlord_id = u.id ORDER BY p.created_at DESC")->fetch_all(MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-md-3">
        <div class="dashboard-sidebar">
            <h5 class="mb-4">Navigation</h5>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="users.php">Manage Users</a></li>
                <li><a href="properties.php" class="active">Manage Properties</a></li>
                <li><a href="applications.php">Applications</a></li>
                <li><a href="messages.php">Messages</a></li>
            </ul>
        </div>
    </div>

    <div class="col-md-9">
        <h2 class="mb-4">Manage Properties</h2>

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
                        <th>Title</th>
                        <th>Location</th>
                        <th>Landlord</th>
                        <th>Price</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($properties as $p): ?>
                        <tr>
                            <td><?php echo $p['id']; ?></td>
                            <td><?php echo htmlspecialchars($p['title']); ?></td>
                            <td><?php echo htmlspecialchars($p['location']); ?></td>
                            <td><?php echo htmlspecialchars($p['full_name']); ?></td>
                            <td>₹<?php echo number_format($p['price']); ?></td>
                            <td><?php echo htmlspecialchars($p['room_type']); ?></td>
                            <td>
                                <span class="badge bg-<?php echo $p['status'] == 'available' ? 'success' : 'danger'; ?>">
                                    <?php echo ucfirst($p['status']); ?>
                                </span>
                            </td>
                            <td>
                                <a href="?delete_id=<?php echo $p['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
