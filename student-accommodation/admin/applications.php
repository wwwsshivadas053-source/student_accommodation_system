<?php
$page_title = "Applications - Admin";
$base_path = "../";
include '../config/db.php';
include '../includes/auth_check.php';
restrictAccess(['admin']);
include '../includes/header.php';

$applications = $conn->query("
    SELECT a.*, p.title, p.location, s.full_name as student_name, l.full_name as landlord_name
    FROM applications a 
    JOIN properties p ON a.property_id = p.id 
    JOIN users s ON a.student_id = s.id 
    JOIN users l ON p.landlord_id = l.id 
    ORDER BY a.applied_at DESC
")->fetch_all(MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-md-3">
        <div class="dashboard-sidebar">
            <h5 class="mb-4">Navigation</h5>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="users.php">Manage Users</a></li>
                <li><a href="properties.php">Manage Properties</a></li>
                <li><a href="applications.php" class="active">Applications</a></li>
                <li><a href="messages.php">Messages</a></li>
            </ul>
        </div>
    </div>

    <div class="col-md-9">
        <h2 class="mb-4">All Applications</h2>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student</th>
                        <th>Property</th>
                        <th>Landlord</th>
                        <th>Applied Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($applications as $app): ?>
                        <tr>
                            <td><?php echo $app['id']; ?></td>
                            <td><?php echo htmlspecialchars($app['student_name']); ?></td>
                            <td><?php echo htmlspecialchars($app['title']); ?></td>
                            <td><?php echo htmlspecialchars($app['landlord_name']); ?></td>
                            <td><?php echo date('d M Y', strtotime($app['applied_at'])); ?></td>
                            <td>
                                <span class="badge bg-<?php 
                                    if ($app['status'] == 'approved') echo 'success';
                                    elseif ($app['status'] == 'rejected') echo 'danger';
                                    else echo 'warning';
                                ?>">
                                    <?php echo ucfirst($app['status']); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
