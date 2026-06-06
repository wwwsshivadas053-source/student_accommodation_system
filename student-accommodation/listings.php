<?php
$page_title = "Listings - Student Accommodation";
$base_path = "";
include 'includes/header.php';

$search = $_GET['search'] ?? '';
$location = $_GET['location'] ?? '';
$priceMin = $_GET['priceMin'] ?? '';
$priceMax = $_GET['priceMax'] ?? '';
$roomType = $_GET['roomType'] ?? '';

// Build query
$query = "SELECT p.*, u.full_name FROM properties p JOIN users u ON p.landlord_id = u.id WHERE p.status = 'available'";

if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $query .= " AND (p.title LIKE '%$search%' OR p.description LIKE '%$search%' OR p.location LIKE '%$search%')";
}

if (!empty($location)) {
    $location = $conn->real_escape_string($location);
    $query .= " AND p.location LIKE '%$location%'";
}

if (!empty($priceMin)) {
    $query .= " AND p.price >= " . (int)$priceMin;
}

if (!empty($priceMax)) {
    $query .= " AND p.price <= " . (int)$priceMax;
}

if (!empty($roomType)) {
    $roomType = $conn->real_escape_string($roomType);
    $query .= " AND p.room_type = '$roomType'";
}

$query .= " ORDER BY p.created_at DESC";

$result = $conn->query($query);
$properties = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-md-3">
        <div class="filter-section">
            <h5 class="mb-4">Filters</h5>
            <form method="GET" id="filterForm">
                <div class="filter-group">
                    <label>Search Keyword</label>
                    <input type="text" class="form-control" name="search" value="<?php echo htmlspecialchars($search); ?>" id="searchBox">
                </div>

                <div class="filter-group">
                    <label>Location</label>
                    <input type="text" class="form-control" name="location" value="<?php echo htmlspecialchars($location); ?>">
                </div>

                <div class="filter-group">
                    <label>Price Range (Min)</label>
                    <input type="number" class="form-control" name="priceMin" value="<?php echo htmlspecialchars($priceMin); ?>">
                </div>

                <div class="filter-group">
                    <label>Price Range (Max)</label>
                    <input type="number" class="form-control" name="priceMax" value="<?php echo htmlspecialchars($priceMax); ?>">
                </div>

                <div class="filter-group">
                    <label>Room Type</label>
                    <select class="form-select" name="roomType">
                        <option value="">All Types</option>
                        <option value="single" <?php echo $roomType == 'single' ? 'selected' : ''; ?>>Single</option>
                        <option value="double" <?php echo $roomType == 'double' ? 'selected' : ''; ?>>Double</option>
                        <option value="2 bedroom" <?php echo $roomType == '2 bedroom' ? 'selected' : ''; ?>>2 Bedroom</option>
                        <option value="3 bedroom" <?php echo $roomType == '3 bedroom' ? 'selected' : ''; ?>>3 Bedroom</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100" id="filterBtn">Apply Filters</button>
            </form>
        </div>
    </div>

    <div class="col-md-9">
        <h2 class="mb-4">Available Accommodations</h2>

        <?php if (count($properties) > 0): ?>
            <div class="row">
                <?php foreach ($properties as $property): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card property-card">
                            <img src="assets/images/placeholder.jpg" alt="<?php echo htmlspecialchars($property['title']); ?>" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($property['title']); ?></h5>
                                <p class="location">📍 <?php echo htmlspecialchars($property['location']); ?></p>
                                <p class="price">₹<?php echo number_format($property['price']); ?>/month</p>
                                <p class="small text-muted mb-2">
                                    <strong>Type:</strong> <?php echo htmlspecialchars($property['room_type']); ?>
                                </p>
                                <p class="card-text small"><?php echo htmlspecialchars(substr($property['description'], 0, 60)) . '...'; ?></p>
                                <p class="small text-muted">By: <?php echo htmlspecialchars($property['full_name']); ?></p>
                                <a href="property_details.php?id=<?php echo $property['id']; ?>" class="btn btn-primary w-100">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info">No properties found matching your criteria.</div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
