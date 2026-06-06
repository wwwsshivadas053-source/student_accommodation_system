<?php
$page_title = "Edit Property";
$base_path = "../";
include '../config/db.php';
include '../includes/auth_check.php';
restrictAccess(['landlord']);
include '../includes/header.php';

$landlord_id = $_SESSION['user_id'];
$property_id = $_GET['id'] ?? null;
$message = "";
$error = "";

if (!$property_id) {
    header("Location: manage_properties.php");
    exit();
}

// Check if property belongs to landlord
$result = $conn->query("SELECT * FROM properties WHERE id = " . (int)$property_id . " AND landlord_id = $landlord_id");
if ($result->num_rows === 0) {
    header("Location: manage_properties.php");
    exit();
}

$property = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $location = trim($_POST['location']);
    $price = (int)$_POST['price'];
    $roomType = $_POST['roomType'];
    $amenities = trim($_POST['amenities']);
    $status = $_POST['status'];

    if (empty($title) || empty($location) || empty($price) || empty($roomType)) {
        $error = "Please fill in all required fields";
    } else {
        $stmt = $conn->prepare("UPDATE properties SET title = ?, description = ?, location = ?, price = ?, room_type = ?, amenities = ?, status = ? WHERE id = ?");
        $stmt->bind_param("sssisssi", $title, $description, $location, $price, $roomType, $amenities, $status, $property_id);

        if ($stmt->execute()) {
            $message = "Property updated successfully!";
            // Refresh property data
            $result = $conn->query("SELECT * FROM properties WHERE id = " . (int)$property_id);
            $property = $result->fetch_assoc();
        } else {
            $error = "Failed to update property. Please try again.";
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
                <li><a href="add_property.php">Add Property</a></li>
                <li><a href="manage_properties.php" class="active">Manage Properties</a></li>
            </ul>
        </div>
    </div>

    <div class="col-md-9">
        <h2 class="mb-4">Edit Property</h2>

        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="card p-4">
            <form method="POST" id="propertyForm">
                <div class="form-group mb-3">
                    <label class="form-label">Property Title</label>
                    <input type="text" class="form-control" name="title" id="title" value="<?php echo htmlspecialchars($property['title']); ?>" required>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="4"><?php echo htmlspecialchars($property['description']); ?></textarea>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" class="form-control" name="location" id="location" value="<?php echo htmlspecialchars($property['location']); ?>" required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Price (Per Month)</label>
                            <input type="number" class="form-control" name="price" id="price" value="<?php echo $property['price']; ?>" min="0" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Room Type</label>
                            <select class="form-select" name="roomType" id="roomType" required>
                                <option value="single" <?php echo $property['room_type'] == 'single' ? 'selected' : ''; ?>>Single</option>
                                <option value="double" <?php echo $property['room_type'] == 'double' ? 'selected' : ''; ?>>Double</option>
                                <option value="2 bedroom" <?php echo $property['room_type'] == '2 bedroom' ? 'selected' : ''; ?>>2 Bedroom</option>
                                <option value="3 bedroom" <?php echo $property['room_type'] == '3 bedroom' ? 'selected' : ''; ?>>3 Bedroom</option>
                                <option value="shared" <?php echo $property['room_type'] == 'shared' ? 'selected' : ''; ?>>Shared</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Amenities</label>
                    <textarea class="form-control" name="amenities" rows="3"><?php echo htmlspecialchars($property['amenities']); ?></textarea>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status" required>
                        <option value="available" <?php echo $property['status'] == 'available' ? 'selected' : ''; ?>>Available</option>
                        <option value="occupied" <?php echo $property['status'] == 'occupied' ? 'selected' : ''; ?>>Occupied</option>
                        <option value="unavailable" <?php echo $property['status'] == 'unavailable' ? 'selected' : ''; ?>>Unavailable</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="manage_properties.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
