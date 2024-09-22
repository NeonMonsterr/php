<?php 
session_start();
if(isset($_SESSION['id'])){
  header("location:home.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Page</title>
  <link rel="stylesheet" href="../css/register.css">
</head>

<body>
  <div class="container">
    <div class="register-container">
      <h2 class="register-title">Register</h2>
      <form action="../backend/server.php" method="post">
        <div class="form-group">
          <label for="first_name">First Name</label>
          <input type="text" id="first_name" placeholder="Enter your first name" name="first_name" required>
        </div>
        <div class="form-group">
          <label for="last_name">Last Name</label>
          <input type="text" id="last_name" placeholder="Enter your last name" name="last_name" required>
        </div>
        <div class="form-group">
          <label for="phone_number">Phone Number</label>
          <input type="tel" id="phone_number" placeholder="Enter your phone number" name="phone_number" required>
          <?php
          if (isset($_GET['phoneError'])) {
            echo "<p class='text-danger is-invalid invalid-feedback'>" . $_GET['phoneError'] . "</p>";
          }
          ?>
        </div>
        <div class="form-group">
          <label for="city">City</label>
          <input type="text" id="city" placeholder="Enter your city" name="city" required>
          <?php
          if (isset($_GET['cityError'])) {
            echo "<p class='text-danger is-invalid invalid-feedback'>" . $_GET['cityError'] . "</p>";
          }
          ?>
        </div>
        <div class="form-group">
          <label for="state">State</label>
          <input type="text" id="state" placeholder="Enter your state" name="state" required>
          <?php
          if (isset($_GET['stateError'])) {
            echo "<p class='text-danger is-invalid invalid-feedback'>" . $_GET['stateError'] . "</p>";
          }
          ?>
        </div>
        <div class="form-group">
          <label for="country">Country</label>
          <input type="text" id="country" placeholder="Enter your country" name="country" required>
          <?php
          if (isset($_GET['countryError'])) {
            echo "<p class='text-danger is-invalid invalid-feedback'>" . $_GET['countryError'] . "</p>";
          }
          ?>
        </div>
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" id="username" placeholder="Enter your username" name="username" required>
          <?php
          if (isset($_GET['nameError'])) {
            echo "<p class='text-danger is-invalid invalid-feedback'>" . $_GET['nameError'] . "</p>";
          }
          ?>
        </div>
        <div class="form-group">
          <label for="email">Email address</label>
          <input type="email" id="email" placeholder="Enter your email" name="email" required>
          <?php
          if (isset($_GET['emailError'])) {
            echo "<p class='text-danger is-invalid invalid-feedback'>" . $_GET['emailError'] . "</p>";
          }
          ?>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" placeholder="Enter your password" name="userpassword" required>
          <?php
          if (isset($_GET['passError'])) {
            echo "<p class='text-danger is-invalid invalid-feedback'>" . $_GET['passError'] . "</p>";
          }
          ?>
        </div>
        <div class="form-group">
          <label for="confirmPassword">Confirm Password</label>
          <input type="password" id="confirmPassword" placeholder="Confirm your password" name="confirmpassword" required>
        </div>
        <div class="submit-btn">
          <button type="submit" name="registerform">Register</button>
        </div>
        <?php
        if(isset($_GET['success'])){
          echo "<div class='alert alert-success' role='alert'>" . htmlspecialchars($_GET['success']) . "</div>";
        }
        ?>
      </form>
      <p class="text-center">Already have an account? <a href="login.php">Login</a></p>
    </div>
  </div>
</body>
</html>
