<?php
$page_title = "Student Dashboard";
$base_path = "../";
include '../config/db.php';
include '../includes/auth_check.php';
restrictAccess(['student']);
include '../includes/header.php';

$student_id = $_SESSION['user_id'];
$user = getCurrentUser($conn);

// Get applications
$applications = $conn->query("
    SELECT a.*, p.title, p.location, p.price, p.room_type 
    FROM applications a 
    JOIN properties p ON a.property_id = p.id 
    WHERE a.student_id = $student_id 
    ORDER BY a.applied_at DESC
")->fetch_all(MYSQLI_ASSOC);

$stats = [
    'total_applications' => count($applications),
    'pending' => count(array_filter($applications, fn($a) => $a['status'] == 'pending')),
    'approved' => count(array_filter($applications, fn($a) => $a['status'] == 'approved')),
    'rejected' => count(array_filter($applications, fn($a) => $a['status'] == 'rejected'))
];
?>

<div class="row">
    <div class="col-md-3">
        <div class="dashboard-sidebar">
            <h5 class="mb-4">Navigation</h5>
            <ul>
                <li><a href="dashboard.php" class="active">Dashboard</a></li>
                <li><a href="../listings.php">Browse Properties</a></li>
                <li><a href="#" onclick="location.reload()">Refresh</a></li>
            </ul>
        </div>
    </div>

    <div class="col-md-9">
        <h2 class="mb-4">Welcome, <?php echo htmlspecialchars($user['full_name']); ?>!</h2>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <h3><?php echo $stats['total_applications']; ?></h3>
                    <p>Total Applications</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <h3><?php echo $stats['pending']; ?></h3>
                    <p>Pending</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <h3><?php echo $stats['approved']; ?></h3>
                    <p>Approved</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <h3><?php echo $stats['rejected']; ?></h3>
                    <p>Rejected</p>
                </div>
            </div>
        </div>

        <div class="card p-4">
            <h4 class="mb-4">Your Applications</h4>

            <?php if (count($applications) > 0): ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Property</th>
                                <th>Location</th>
                                <th>Price</th>
                                <th>Applied Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($applications as $app): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($app['title']); ?></td>
                                    <td><?php echo htmlspecialchars($app['location']); ?></td>
                                    <td>₹<?php echo number_format($app['price']); ?></td>
                                    <td><?php echo date('d M Y', strtotime($app['applied_at'])); ?></td>
                                    <td>
                                        <?php 
                                        $status_class = 'secondary';
                                        if ($app['status'] == 'approved') $status_class = 'success';
                                        elseif ($app['status'] == 'rejected') $status_class = 'danger';
                                        elseif ($app['status'] == 'pending') $status_class = 'warning';
                                        ?>
                                        <span class="badge bg-<?php echo $status_class; ?>">
                                            <?php echo ucfirst($app['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="../property_details.php?id=<?php echo $app['property_id']; ?>" class="btn btn-sm btn-info">View</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    You haven't applied for any properties yet. <a href="../listings.php">Browse properties</a> to get started!
                </div>
            <?php endif; ?>
        </div>

        <div class="card p-4 mt-4">
            <h4 class="mb-3">Profile Information</h4>
            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user['full_name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
            <p><strong>Member Since:</strong> <?php echo date('d M Y', strtotime($user['created_at'])); ?></p>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
