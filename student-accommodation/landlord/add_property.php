<?php
$page_title = "Add Property";
$base_path = "../";
include '../config/db.php';
include '../includes/auth_check.php';
restrictAccess(['landlord']);
include '../includes/header.php';

$landlord_id = $_SESSION['user_id'];
$message = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $location = trim($_POST['location']);
    $price = (int)$_POST['price'];
    $roomType = $_POST['roomType'];
    $amenities = trim($_POST['amenities']);

    if (empty($title) || empty($location) || empty($price) || empty($roomType)) {
        $error = "Please fill in all required fields";
    } else {
        $stmt = $conn->prepare("INSERT INTO properties (landlord_id, title, description, location, price, room_type, amenities, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'available')");
        $stmt->bind_param("isssiss", $landlord_id, $title, $description, $location, $price, $roomType, $amenities);

        if ($stmt->execute()) {
            $message = "Property added successfully! <a href='dashboard.php'>Go to Dashboard</a>";
        } else {
            $error = "Failed to add property. Please try again.";
        }
    }
}
?>

<div class="row">
    <div class="col-md-3">
        <div class="dashboard-sidebar">
            <h5 class="mb-4">Navigation</h5>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="add_property.php" class="active">Add Property</a></li>
                <li><a href="manage_properties.php">Manage Properties</a></li>
            </ul>
        </div>
    </div>

    <div class="col-md-9">
        <h2 class="mb-4">Add New Property</h2>

        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="card p-4">
            <form method="POST" id="propertyForm">
                <div class="form-group mb-3">
                    <label class="form-label">Property Title *</label>
                    <input type="text" class="form-control" name="title" id="title" required>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="4" placeholder="Describe your property..."></textarea>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Location *</label>
                    <input type="text" class="form-control" name="location" id="location" required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Price (Per Month) *</label>
                            <input type="number" class="form-control" name="price" id="price" min="0" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Room Type *</label>
                            <select class="form-select" name="roomType" id="roomType" required>
                                <option value="">Select Room Type</option>
                                <option value="single">Single</option>
                                <option value="double">Double</option>
                                <option value="2 bedroom">2 Bedroom</option>
                                <option value="3 bedroom">3 Bedroom</option>
                                <option value="shared">Shared</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Amenities</label>
                    <textarea class="form-control" name="amenities" rows="3" placeholder="e.g., WiFi, AC, Kitchen, Parking, Balcony..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Add Property</button>
                <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
