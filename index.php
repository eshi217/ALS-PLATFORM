<?php
session_start();
include "conn.php"; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Check if email exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['userid'] = $user['userid'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_type'] = $user['user_type']; // Store user type in session

            echo json_encode(["status" => "success", "user_type" => $_SESSION['user_type']]);
            exit();
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid email or password!"]);
            exit();
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Error: " . $e->getMessage()]);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ALS Platform</title>
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css"> <!-- Custom CSS -->
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="LOGO.png" alt="ALS Lambunao Logo" width="60" height="60" class="me-2">
            ALS LAMBUNAO
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link nav-register" href="login.php">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<div class="hero">
    <div class="container text-center">
        <h1 class="animate-fade-in">Welcome to the ALS E-Learning Platform</h1>
        
    </div>
</div>

<!-- Footer -->
<footer class="footer">
    <p>&copy; <?php echo date("Y"); ?> Alternative Learning System E-Learning Platform. All Rights Reserved.</p>
</footer>

<script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
