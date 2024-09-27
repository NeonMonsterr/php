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
    <title>About Us - VcpRagon</title>
    <link rel="stylesheet" href="../css/home.css"> <!-- Use the same CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

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

    <!-- About Section -->
    <section id="about" class="about-section">
        <h2>About Us</h2>
        <div class="about-container">
            <img src="../pics/VcpRagon4.jpg" alt="About Us" class="about-image"> <!-- Added class for styling -->
            <div class="about-text">
                <p>We are a creative agency with a passion for modern and minimal design. Our team specializes in creating elegant solutions that capture the essence of simplicity and style.</p>
                <p>With years of experience in the industry, we strive to bring innovative ideas to life, ensuring each project reflects our commitment to quality and excellence.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 MyWebsite. All rights reserved.</p>
    </footer>
</body>
</html>
