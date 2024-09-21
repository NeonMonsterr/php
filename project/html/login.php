<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link rel="stylesheet" href="../css/login.css">
</head>
<body>
  <div class="container">
    <div class="login-container">
      <h2 class="login-title">Login</h2>
      <form action="../backend/server.php" method="post">
        <div class="form-group">
          <label for="email">Email address</label>
          <input type="email" id="email" placeholder="Enter your email"name="loginemail">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" placeholder="Enter your password" name="loginpass">
        </div>
        <?php
        if(isset($_GET['loginError'])){
          echo "<p class='text-danger is-invalid invalid-feedback'>" . $_GET['loginError'] . "</p>";
        }
        ?>
        <div class="submit-btn">
          <button type="submit" name="loginform">Login</button>
        </div>
      </form>
      <p class="text-center">Don't have an account? <a href="#">Register</a></p>
    </div>
  </div>
</body>
</html>
