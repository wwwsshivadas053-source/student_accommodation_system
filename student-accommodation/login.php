<?php
$page_title = "Login - Student Accommodation";
$base_path = "";
include 'includes/header.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Email and password are required";
    } else {
        $result = $conn->query("SELECT * FROM users WHERE email = '$email'");

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                // Set session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['role'] = $user['role'];

                // Redirect based on role
                if ($user['role'] == 'student') {
                    header("Location: student/dashboard.php");
                } elseif ($user['role'] == 'landlord') {
                    header("Location: landlord/dashboard.php");
                } else {
                    header("Location: admin/dashboard.php");
                }
                exit();
            } else {
                $error = "Invalid email or password";
            }
        } else {
            $error = "Invalid email or password";
        }
    }
}

// Demo credentials
$demoCredentials = [
    ['email' => 'student@example.com', 'password' => 'password', 'role' => 'Student'],
    ['email' => 'landlord@example.com', 'password' => 'password', 'role' => 'Landlord'],
    ['email' => 'admin@accommodation.com', 'password' => 'password', 'role' => 'Admin']
];
?>

</div>

<div class="auth-container">
    <h2>Login to Your Account</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" id="loginForm">
        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>

        <div class="form-text">
            Don't have an account? <a href="register.php">Register here</a>
        </div>
    </form>

    <hr>

    <div class="alert alert-info">
        <strong>Demo Accounts:</strong>
        <ul class="mb-0">
            <?php foreach ($demoCredentials as $demo): ?>
                <li><?php echo $demo['role']; ?>: <?php echo $demo['email']; ?> / <?php echo $demo['password']; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<div class="container">

<?php include 'includes/footer.php'; ?>
