<?php
$page_title = "Landlord Dashboard";
$base_path = "../";
include '../config/db.php';
include '../includes/auth_check.php';
restrictAccess(['landlord']);
include '../includes/header.php';

$landlord_id = $_SESSION['user_id'];
$user = getCurrentUser($conn);

// Get properties
$properties = $conn->query("SELECT * FROM properties WHERE landlord_id = $landlord_id ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);

// Get applications
$applications = $conn->query("
    SELECT a.*, p.title, p.location, u.full_name as student_name, u.email as student_email 
    FROM applications a 
    JOIN properties p ON a.property_id = p.id 
    JOIN users u ON a.student_id = u.id 
    WHERE p.landlord_id = $landlord_id 
    ORDER BY a.applied_at DESC
")->fetch_all(MYSQLI_ASSOC);

$message = "";
$error = "";

// Handle status update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $app_id = (int)$_POST['app_id'];
    $status = $_POST['status'];
    
    $stmt = $conn->prepare("UPDATE applications SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $app_id);
    
    if ($stmt->execute()) {
        $message = "Application status updated successfully!";
    } else {
        $error = "Failed to update status";
    }
}
?>

<div class="row">
    <div class="col-md-3">
        <div class="dashboard-sidebar">
            <h5 class="mb-4">Navigation</h5>
            <ul>
                <li><a href="dashboard.php" class="active">Dashboard</a></li>
                <li><a href="add_property.php">Add Property</a></li>
                <li><a href="manage_properties.php">Manage Properties</a></li>
            </ul>
        </div>
    </div>

    <div class="col-md-9">
        <h2 class="mb-4">Welcome, <?php echo htmlspecialchars($user['full_name']); ?>!</h2>

        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <h3><?php echo count($properties); ?></h3>
                    <p>Total Properties</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <h3><?php echo count(array_filter($properties, fn($p) => $p['status'] == 'available')); ?></h3>
                    <p>Available</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <h3><?php echo count($applications); ?></h3>
                    <p>Total Applications</p>
                </div>
            </div>
        </div>

        <div class="card p-4 mb-4">
            <h4 class="mb-4">Your Properties</h4>
            <a href="add_property.php" class="btn btn-success mb-3">+ Add New Property</a>
            
            <?php if (count($properties) > 0): ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Location</th>
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
                                    <td>₹<?php echo number_format($prop['price']); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo $prop['status'] == 'available' ? 'success' : 'danger'; ?>">
                                            <?php echo ucfirst($prop['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="edit_property.php?id=<?php echo $prop['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
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

        <div class="card p-4">
            <h4 class="mb-4">Applications from Students</h4>
            
            <?php if (count($applications) > 0): ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Property</th>
                                <th>Applied Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($applications as $app): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($app['student_name']); ?></td>
                                    <td><?php echo htmlspecialchars($app['title']); ?></td>
                                    <td><?php echo date('d M Y', strtotime($app['applied_at'])); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo $app['status'] == 'pending' ? 'warning' : ($app['status'] == 'approved' ? 'success' : 'danger'); ?>">
                                            <?php echo ucfirst($app['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="app_id" value="<?php echo $app['id']; ?>">
                                            <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                                                <option value="pending" <?php echo $app['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                                <option value="approved" <?php echo $app['status'] == 'approved' ? 'selected' : ''; ?>>Approve</option>
                                                <option value="rejected" <?php echo $app['status'] == 'rejected' ? 'selected' : ''; ?>>Reject</option>
                                            </select>
                                            <input type="hidden" name="update_status" value="1">
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info">No applications yet.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
