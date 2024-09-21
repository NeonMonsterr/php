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
  <title>Contact Us</title>
  <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
  <header>
    <nav>
      <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="about.php">About Us</a></li>
        <li><a href="shop.php">Shop</a></li>
        <li><a href="contact.php">Contact Us</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <h1>Contact Us</h1>
    <p>If you have any questions, feel free to reach out to us via email or phone.</p>
    <form>
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" placeholder="Enter your name">
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Enter your email">
      </div>
      <div class="form-group">
        <label for="message">Message</label>
        <textarea id="message" placeholder="Write your message here"></textarea>
      </div>
      <button type="submit">Submit</button>
    </form>
  </main>
</body>
</html>
