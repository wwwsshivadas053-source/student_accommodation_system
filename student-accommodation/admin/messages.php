<?php
$page_title = "Messages - Admin";
$base_path = "../";
include '../config/db.php';
include '../includes/auth_check.php';
restrictAccess(['admin']);
include '../includes/header.php';

$message = "";
$error = "";

// Handle message deletion
if (isset($_GET['delete_id'])) {
    $msg_id = (int)$_GET['delete_id'];
    if ($conn->query("DELETE FROM messages WHERE id = $msg_id")) {
        $message = "Message deleted successfully!";
    } else {
        $error = "Failed to delete message.";
    }
}

$messages = $conn->query("SELECT * FROM messages ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-md-3">
        <div class="dashboard-sidebar">
            <h5 class="mb-4">Navigation</h5>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="users.php">Manage Users</a></li>
                <li><a href="properties.php">Manage Properties</a></li>
                <li><a href="applications.php">Applications</a></li>
                <li><a href="messages.php" class="active">Messages</a></li>
            </ul>
        </div>
    </div>

    <div class="col-md-9">
        <h2 class="mb-4">Contact Messages</h2>

        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (count($messages) > 0): ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($messages as $msg): ?>
                            <tr>
                                <td><?php echo $msg['id']; ?></td>
                                <td><?php echo htmlspecialchars($msg['name']); ?></td>
                                <td><?php echo htmlspecialchars($msg['email']); ?></td>
                                <td><?php echo htmlspecialchars($msg['subject']); ?></td>
                                <td><?php echo date('d M Y', strtotime($msg['created_at'])); ?></td>
                                <td>
                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#messageModal<?php echo $msg['id']; ?>">View</button>
                                    <a href="?delete_id=<?php echo $msg['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                                </td>
                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="messageModal<?php echo $msg['id']; ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"><?php echo htmlspecialchars($msg['subject']); ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>From:</strong> <?php echo htmlspecialchars($msg['name']); ?></p>
                                            <p><strong>Email:</strong> <?php echo htmlspecialchars($msg['email']); ?></p>
                                            <p><strong>Date:</strong> <?php echo date('d M Y, H:i', strtotime($msg['created_at'])); ?></p>
                                            <hr>
                                            <p><?php echo nl2br(htmlspecialchars($msg['message'])); ?></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">No messages yet.</div>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
