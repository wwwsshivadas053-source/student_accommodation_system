<?php
$page_title = "Register - Student Accommodation";
$base_path = "";
include 'includes/header.php';

$message = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullName = trim($_POST['fullName']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $phone = trim($_POST['phone']);
    $role = $_POST['role'];

    // Validation
    if (empty($fullName) || empty($email) || empty($password) || empty($phone)) {
        $error = "All fields are required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters";
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match";
    } else {
        // Check if email already exists
        $checkEmail = $conn->query("SELECT id FROM users WHERE email = '$email'");
        if ($checkEmail->num_rows > 0) {
            $error = "Email already registered";
        } else {
            // Hash password and insert
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, role, phone) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $fullName, $email, $hashedPassword, $role, $phone);

            if ($stmt->execute()) {
                $message = "Registration successful! <a href='login.php'>Login here</a>";
            } else {
                $error = "Registration failed. Please try again";
            }
        }
    }
}
?>

</div>

<div class="auth-container">
    <h2>Create Account</h2>

    <?php if ($message): ?>
        <div class="alert alert-success"><?php echo $message; ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" id="registerForm">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" class="form-control" id="fullName" name="fullName" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label>Phone Number</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="10-digit number" required>
        </div>

        <div class="form-group">
            <label>Register As</label>
            <select class="form-select" name="role" required>
                <option value="student">Student</option>
                <option value="landlord">Landlord</option>
            </select>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Register</button>

        <div class="form-text">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </form>
</div>

<div class="container">

<?php include 'includes/footer.php'; ?>
