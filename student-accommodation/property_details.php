<?php
$page_title = "Property Details - Student Accommodation";
$base_path = "";
include 'includes/header.php';

$propertyId = $_GET['id'] ?? null;

if (!$propertyId) {
    header("Location: listings.php");
    exit();
}

$result = $conn->query("SELECT p.*, u.* FROM properties p JOIN users u ON p.landlord_id = u.id WHERE p.id = " . (int)$propertyId);

if ($result->num_rows === 0) {
    header("Location: listings.php");
    exit();
}

$property = $result->fetch_assoc();
?>

<div class="row">
    <div class="col-md-8">
        <img src="assets/images/placeholder.jpg" alt="<?php echo htmlspecialchars($property['title']); ?>" class="img-fluid rounded mb-4">

        <h1><?php echo htmlspecialchars($property['title']); ?></h1>
        <p class="text-muted mb-4">
            📍 <?php echo htmlspecialchars($property['location']); ?>
        </p>

        <div class="card mb-4 p-4">
            <h3 class="price">₹<?php echo number_format($property['price']); ?>/month</h3>
            <p class="mb-0"><strong>Room Type:</strong> <?php echo htmlspecialchars($property['room_type']); ?></p>
        </div>

        <h3>Description</h3>
        <p><?php echo nl2br(htmlspecialchars($property['description'])); ?></p>

        <h3>Amenities</h3>
        <p><?php echo nl2br(htmlspecialchars($property['amenities'])); ?></p>

        <h3>Availability</h3>
        <p>
            <span class="badge bg-success">
                <?php echo ucfirst($property['status']); ?>
            </span>
        </p>
    </div>

    <div class="col-md-4">
        <div class="card p-4 sticky-top">
            <h4>Landlord Information</h4>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($property['full_name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($property['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($property['phone']); ?></p>

            <?php if (isLoggedIn() && userRole() == 'student'): ?>
                <a href="apply.php?id=<?php echo $property['id']; ?>" class="btn btn-primary w-100 mb-2">
                    Apply Now
                </a>
            <?php elseif (!isLoggedIn()): ?>
                <a href="login.php" class="btn btn-primary w-100 mb-2">
                    Login to Apply
                </a>
            <?php endif; ?>

            <a href="listings.php" class="btn btn-outline-primary w-100">
                Back to Listings
            </a>

            <div class="mt-4 p-3 bg-light rounded">
                <p class="small mb-0">
                    Listed on: <?php echo date('d M Y', strtotime($property['created_at'])); ?>
                </p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
