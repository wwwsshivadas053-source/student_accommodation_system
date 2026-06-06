<?php
$page_title = "Contact Us - Student Accommodation";
$base_path = "";
include 'includes/header.php';

$message = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $messageText = trim($_POST['message']);

    if (empty($name) || empty($email) || empty($subject) || empty($messageText)) {
        $error = "All fields are required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } else {
        $stmt = $conn->prepare("INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $messageText);

        if ($stmt->execute()) {
            $message = "Thank you! Your message has been sent successfully. We will get back to you soon.";
        } else {
            $error = "Failed to send message. Please try again.";
        }
    }
}
?>

<div class="row">
    <div class="col-md-8">
        <h2 class="mb-4">Contact Us</h2>

        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" id="contactForm" class="card p-4">
            <div class="form-group mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="form-group mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="form-group mb-3">
                <label class="form-label">Subject</label>
                <input type="text" class="form-control" id="subject" name="subject" required>
            </div>

            <div class="form-group mb-3">
                <label class="form-label">Message</label>
                <textarea class="form-control" id="message" name="message" rows="6" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Send Message</button>
        </form>
    </div>

    <div class="col-md-4">
        <div class="card p-4 mb-4">
            <h5>Contact Information</h5>
            <p><strong>Email:</strong><br>info@accommodation.com</p>
            <p><strong>Phone:</strong><br>+91-1234567890</p>
            <p><strong>Address:</strong><br>123 Education Lane<br>University City</p>
        </div>

        <div class="card p-4">
            <h5>Hours</h5>
            <p>Monday - Friday: 9:00 AM - 6:00 PM<br>
            Saturday: 10:00 AM - 4:00 PM<br>
            Sunday: Closed</p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
