<?php
include 'auth_check.php';
include __DIR__ . '/../config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Student Accommodation'; ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo isset($base_path) ? $base_path : ''; ?>assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?php echo isset($base_path) ? $base_path : ''; ?>index.php">
            🏠 Student Accommodation
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo isset($base_path) ? $base_path : ''; ?>listings.php">Listings</a>
                </li>
                
                <?php if (isLoggedIn()): ?>
                    <?php if (userRole() == 'student'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo isset($base_path) ? $base_path : ''; ?>student/dashboard.php">Dashboard</a>
                        </li>
                    <?php elseif (userRole() == 'landlord'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo isset($base_path) ? $base_path : ''; ?>landlord/dashboard.php">Dashboard</a>
                        </li>
                    <?php elseif (userRole() == 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo isset($base_path) ? $base_path : ''; ?>admin/dashboard.php">Dashboard</a>
                        </li>
                    <?php endif; ?>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo isset($base_path) ? $base_path : ''; ?>logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo isset($base_path) ? $base_path : ''; ?>login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo isset($base_path) ? $base_path : ''; ?>register.php">Register</a>
                    </li>
                <?php endif; ?>
                
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo isset($base_path) ? $base_path : ''; ?>contact.php">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
