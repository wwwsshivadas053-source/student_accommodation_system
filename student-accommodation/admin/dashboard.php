<?php
$page_title = "Admin Dashboard";
$base_path = "../";
include '../config/db.php';
include '../includes/auth_check.php';
restrictAccess(['admin']);
include '../includes/header.php';

$user = getCurrentUser($conn);

// Get stats
$stats = [
    'total_users' => $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'],
    'students' => $conn->query("SELECT COUNT(*) as count FROM users WHERE role = 'student'")->fetch_assoc()['count'],
    'landlords' => $conn->query("SELECT COUNT(*) as count FROM users WHERE role = 'landlord'")->fetch_assoc()['count'],
    'properties' => $conn->query("SELECT COUNT(*) as count FROM properties")->fetch_assoc()['count'],
    'applications' => $conn->query("SELECT COUNT(*) as count FROM applications")->fetch_assoc()['count'],
    'messages' => $conn->query("SELECT COUNT(*) as count FROM messages")->fetch_assoc()['count']
];

$message = "";
$error = "";

// Handle user deletion
if (isset($_GET['delete_user'])) {
    $user_id = (int)$_GET['delete_user'];
    if ($user_id != $_SESSION['user_id']) { // Can't delete yourself
        if ($conn->query("DELETE FROM users WHERE id = $user_id")) {
            $message = "User deleted successfully!";
        } else {
            $error = "Failed to delete user.";
        }
    }
}
?>

<div class="row">
    <div class="col-md-3">
        <div class="dashboard-sidebar">
            <h5 class="mb-4">Navigation</h5>
            <ul>
                <li><a href="dashboard.php" class="active">Dashboard</a></li>
                <li><a href="users.php">Manage Users</a></li>
                <li><a href="properties.php">Manage Properties</a></li>
                <li><a href="applications.php">Applications</a></li>
                <li><a href="messages.php">Messages</a></li>
            </ul>
        </div>
    </div>

    <div class="col-md-9">
        <h2 class="mb-4">Admin Dashboard</h2>

        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <h3><?php echo $stats['total_users']; ?></h3>
                    <p>Total Users</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <h3><?php echo $stats['properties']; ?></h3>
                    <p>Properties</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <h3><?php echo $stats['applications']; ?></h3>
                    <p>Applications</p>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <h3><?php echo $stats['students']; ?></h3>
                    <p>Students</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <h3><?php echo $stats['landlords']; ?></h3>
                    <p>Landlords</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <h3><?php echo $stats['messages']; ?></h3>
                    <p>Contact Messages</p>
                </div>
            </div>
        </div>

        <div class="card p-4 mb-4">
            <h4 class="mb-3">Quick Links</h4>
            <a href="users.php" class="btn btn-primary me-2">Manage Users</a>
            <a href="properties.php" class="btn btn-primary me-2">Manage Properties</a>
            <a href="applications.php" class="btn btn-primary me-2">View Applications</a>
            <a href="messages.php" class="btn btn-primary">View Messages</a>
        </div>

        <div class="card p-4">
            <h4 class="mb-3">System Information</h4>
            <p><strong>Admin Name:</strong> <?php echo htmlspecialchars($user['full_name']); ?></p>
            <p><strong>Admin Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Last Login:</strong> <?php echo date('d M Y, H:i'); ?></p>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
