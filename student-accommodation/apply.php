<?php
$page_title = "Apply for Accommodation";
$base_path = "";
include 'config/db.php';
include 'includes/auth_check.php';
restrictAccess(['student']);
include 'includes/header.php';

$propertyId = $_GET['id'] ?? null;
$message = "";
$error = "";

if (!$propertyId) {
    header("Location: listings.php");
    exit();
}

// Check if property exists
$result = $conn->query("SELECT * FROM properties WHERE id = " . (int)$propertyId);
if ($result->num_rows === 0) {
    header("Location: listings.php");
    exit();
}

$property = $result->fetch_assoc();

// Check if already applied
$applied = $conn->query("SELECT id FROM applications WHERE student_id = " . $_SESSION['user_id'] . " AND property_id = " . (int)$propertyId);
if ($applied->num_rows > 0) {
    $error = "You have already applied for this property";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($error)) {
    $message = trim($_POST['message']);

    if (empty($message)) {
        $error = "Please write a message for your application";
    } else {
        $stmt = $conn->prepare("INSERT INTO applications (student_id, property_id, message, status) VALUES (?, ?, ?, 'pending')");
        $stmt->bind_param("iis", $_SESSION['user_id'], $propertyId, $message);

        if ($stmt->execute()) {
            $message = "Application submitted successfully! You can track your application status in your dashboard.";
        } else {
            $error = "Failed to submit application. Please try again.";
        }
    }
}
?>

<div class="row">
    <div class="col-md-8">
        <h2>Apply for <?php echo htmlspecialchars($property['title']); ?></h2>

        <?php if ($message && !$error): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
            <a href="student/dashboard.php" class="btn btn-primary">Go to Dashboard</a>
        <?php else: ?>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if (!$error): ?>
                <div class="card p-4 mb-4">
                    <h5>Property Information</h5>
                    <p><strong>Title:</strong> <?php echo htmlspecialchars($property['title']); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($property['location']); ?></p>
                    <p><strong>Price:</strong> ₹<?php echo number_format($property['price']); ?>/month</p>
                    <p><strong>Room Type:</strong> <?php echo htmlspecialchars($property['room_type']); ?></p>
                </div>

                <form method="POST" id="applicationForm">
                    <div class="form-group mb-4">
                        <label class="form-label">Why do you want this room? (Message to Landlord)</label>
                        <textarea class="form-control" name="message" rows="6" placeholder="Introduce yourself and explain why you're interested..." id="message"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit Application</button>
                    <a href="property_details.php?id=<?php echo $propertyId; ?>" class="btn btn-secondary">Cancel</a>
                </form>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <div class="col-md-4">
        <div class="card p-4">
            <h5>Application Tips</h5>
            <ul class="small">
                <li>Write a friendly introduction</li>
                <li>Mention your study program/college</li>
                <li>Explain your accommodation needs</li>
                <li>Be professional and respectful</li>
                <li>Check your dashboard for updates</li>
            </ul>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
