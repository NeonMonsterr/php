<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../html/login.php?loginError=You must log in first.");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Stylish Modern Homepage</title>
  <link rel="stylesheet" href="../css/home.css"> <!-- External CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome -->
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
            <span id="cart-count">0</span> <!-- Placeholder for cart count -->
        </div>
        <ul class="nav-links">
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </nav>
</header>


  <!-- Hero Section -->
  <section id="home" class="hero">
    <div class="hero-content">
      <h1>Welcome to VcpRagon</h1>
      <p>Stylish, Minimal, and Modern Design</p>
      <a href="#services" class="btn">Explore Now</a>
    </div>
  </section>

  <!-- About Section with Image -->
  <section id="about" class="about-section">
    <h2>About Us</h2>
    <div class="about-container">
      <p>We are a creative agency with a passion for modern and minimal design. Our team specializes in creating elegant solutions that capture the essence of simplicity and style.</p>
    </div>
  </section>

  <!-- Services Section with Images -->
  <section id="services" class="services-section">
    <h2>Our Services</h2>
    <div class="service-container">
      <div class="service-card">
        <img src="../pics/web.png" alt="Web Design">
        <h3>Web Design</h3>
        <p>Creating beautiful and responsive websites.</p>
      </div>
      <div class="service-card">
        <img src="../pics/mareketing.jpg" alt="Marketing">
        <h3>Marketing</h3>
        <p>Driving growth through effective marketing strategies.</p>
      </div>
      <div class="service-card">
        <img src="../pics/seo.jpg" alt="SEO Optimization">
        <h3>SEO Optimization</h3>
        <p>Boosting your site's presence on search engines.</p>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact" class="contact-section">
    <h2>Contact Us</h2>
    <p>Feel free to reach out to us for any inquiries.</p>
    <a href="mailto:contact@mywebsite.com" class="btn">Email Us</a>
  </section>

  <!-- Footer -->
  <footer>
    <p>&copy; 2024 MyWebsite. All rights reserved.</p>
  </footer>
</body>

</html>
