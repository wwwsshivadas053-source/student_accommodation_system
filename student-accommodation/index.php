<?php
$page_title = "Home - Student Accommodation";
$base_path = "";
include 'includes/header.php';

// Get featured properties
$result = $conn->query("SELECT p.*, u.full_name FROM properties p JOIN users u ON p.landlord_id = u.id WHERE p.status = 'available' ORDER BY p.created_at DESC LIMIT 6");
$properties = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="hero">
    <h1>Find Your Perfect Student Accommodation</h1>
    <p>Search and apply for student housing online</p>
    <form class="search-box" action="listings.php" method="GET">
        <input type="text" name="search" placeholder="Search by location...">
        <button type="submit">Search</button>
    </form>
</div>

<div class="row mb-5">
    <div class="col-md-4">
        <div class="stat-card">
            <h3><?php echo $conn->query("SELECT COUNT(*) as count FROM properties WHERE status = 'available'")->fetch_assoc()['count']; ?></h3>
            <p>Available Properties</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <h3><?php echo $conn->query("SELECT COUNT(*) as count FROM users WHERE role = 'landlord'")->fetch_assoc()['count']; ?></h3>
            <p>Active Landlords</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <h3><?php echo $conn->query("SELECT COUNT(*) as count FROM applications")->fetch_assoc()['count']; ?></h3>
            <p>Total Applications</p>
        </div>
    </div>
</div>

<h2 class="mb-4">Featured Accommodations</h2>

<div class="row mb-5">
    <?php foreach ($properties as $property): ?>
        <div class="col-md-4 mb-4">
            <div class="card property-card">
                <img src="assets/images/placeholder.jpg" alt="<?php echo htmlspecialchars($property['title']); ?>" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($property['title']); ?></h5>
                    <p class="location">📍 <?php echo htmlspecialchars($property['location']); ?></p>
                    <p class="price">₹<?php echo number_format($property['price']); ?>/month</p>
                    <p class="card-text small"><?php echo htmlspecialchars(substr($property['description'], 0, 60)) . '...'; ?></p>
                    <p class="small text-muted">By: <?php echo htmlspecialchars($property['full_name']); ?></p>
                    <a href="property_details.php?id=<?php echo $property['id']; ?>" class="btn btn-primary w-100">View Details</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<section class="bg-light p-5 rounded mb-5">
    <h2 class="mb-4">How It Works</h2>
    <div class="row">
        <div class="col-md-3 text-center">
            <h4>1. Search</h4>
            <p>Browse available accommodations in your desired location</p>
        </div>
        <div class="col-md-3 text-center">
            <h4>2. Compare</h4>
            <p>Compare prices, amenities, and details</p>
        </div>
        <div class="col-md-3 text-center">
            <h4>3. Apply</h4>
            <p>Submit your application online</p>
        </div>
        <div class="col-md-3 text-center">
            <h4>4. Get Approved</h4>
            <p>Track your application status in real-time</p>
        </div>
    </div>
</section>

<section class="mb-5">
    <h2 class="mb-4">Why Choose Us?</h2>
    <ul class="list-group">
        <li class="list-group-item">✅ Safe and Verified Listings</li>
        <li class="list-group-item">✅ Easy Online Application Process</li>
        <li class="list-group-item">✅ Direct Communication with Landlords</li>
        <li class="list-group-item">✅ Mobile-Friendly Platform</li>
        <li class="list-group-item">✅ 24/7 Support</li>
    </ul>
</section>

<?php include 'includes/footer.php'; ?>
