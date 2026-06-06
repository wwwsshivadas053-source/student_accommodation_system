<?php
$page_title = "Manage Properties";
$base_path = "../";
include '../config/db.php';
include '../includes/auth_check.php';
restrictAccess(['landlord']);
include '../includes/header.php';

$landlord_id = $_SESSION['user_id'];
$message = "";
$error = "";

// Handle delete
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    
    // Verify ownership
    $check = $conn->query("SELECT landlord_id FROM properties WHERE id = $delete_id");
    $prop = $check->fetch_assoc();
    
    if ($prop && $prop['landlord_id'] == $landlord_id) {
        if ($conn->query("DELETE FROM properties WHERE id = $delete_id")) {
            $message = "Property deleted successfully!";
        } else {
            $error = "Failed to delete property.";
        }
    }
}

// Get all properties
$properties = $conn->query("SELECT * FROM properties WHERE landlord_id = $landlord_id ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-md-3">
        <div class="dashboard-sidebar">
            <h5 class="mb-4">Navigation</h5>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="add_property.php">Add Property</a></li>
                <li><a href="manage_properties.php" class="active">Manage Properties</a></li>
            </ul>
        </div>
    </div>

    <div class="col-md-9">
        <h2 class="mb-4">Manage Your Properties</h2>

        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <a href="add_property.php" class="btn btn-success mb-3">+ Add New Property</a>

        <?php if (count($properties) > 0): ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Location</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($properties as $prop): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($prop['title']); ?></td>
                                <td><?php echo htmlspecialchars($prop['location']); ?></td>
                                <td><?php echo htmlspecialchars($prop['room_type']); ?></td>
                                <td>₹<?php echo number_format($prop['price']); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $prop['status'] == 'available' ? 'success' : 'danger'; ?>">
                                        <?php echo ucfirst($prop['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="edit_property.php?id=<?php echo $prop['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="?delete_id=<?php echo $prop['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">No properties yet. <a href="add_property.php">Add one now</a>!</div>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
