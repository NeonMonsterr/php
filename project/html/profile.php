<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../html/login.php?loginError=You must log in first.");
    exit();
}
require "../backend/connection.php";
$result = $db->conn->prepare("SELECT SUM(quantity) AS total_items FROM order_items oi JOIN orders o ON oi.order_id = o.order_id WHERE o.user_id = :userId AND o.status = 'pending'");
$result->execute(['userId' => $_SESSION['id']]);
$cartCount = $result->fetch(PDO::FETCH_ASSOC)['total_items'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile - VcpRagon</title>
    <link rel="stylesheet" href="../css/home.css"> <!-- Your custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <!-- Navigation Bar -->
    <header>
        <nav class="navbar">
            <div class="logo">VcpRagon</div>
            <div class="user-info">
                <i class="fas fa-user-circle"></i>
                <span><?php echo $_SESSION['username']; ?></span>
            </div>
            <div class="cart-icon">
                <i class="fas fa-shopping-cart"></i>
                <span id="cart-count"><?php echo htmlspecialchars($cartCount); ?></span>
                <a href="cart_checkout.php" class="btn btn-warning">Go to Cart</a>
            </div>
            <ul class="nav-links">
                <li><a href="home.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>
        </nav>
    </header>

    <!-- Profile Section -->
    <section id="profile" class="profile-section py-5">
        <div class="container">
            <h2 class="text-center mb-4">Your Profile</h2>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Username</h5>
                            <p class="card-text"><?php echo $_SESSION['username']; ?></p>

                            <h5 class="card-title">Email</h5>
                            <p class="card-text"><?php echo $_SESSION['email']; ?></p>

                            <h5 class="card-title">Bio</h5>
                            <p class="card-text">Tell us about yourself...</p> <!-- Placeholder for bio -->
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <form action="../backend/logout.php" method="post">
                            <button type="submit" class="btn btn-danger">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 MyWebsite. All rights reserved.</p>
    </footer>

</body>
</html>