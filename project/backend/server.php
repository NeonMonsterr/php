<?php
require "connection.php"; 

if (isset($_POST['registerform'])) {
    $firstname = htmlspecialchars(trim($_POST['first_name']));
    $lastname = htmlspecialchars(trim($_POST['last_name']));
    $phonenumber = htmlspecialchars(trim($_POST['phone_number']));
    $city = htmlspecialchars(trim($_POST['city']));
    $state = htmlspecialchars(trim($_POST['state']));
    $country = htmlspecialchars(trim($_POST['country']));
    $name = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['userpassword'];
    $confirmpass = $_POST['confirmpassword'];

    // Validation patterns
    $namePattern = "/^[A-Za-z0-9_]{3,}$/";
    $phonePattern = "/^[0-9]{10,15}$/"; 
    $cityPattern = "/^[A-Za-z\s]{2,}$/"; 
    $statePattern = "/^[A-Za-z\s]{2,}$/"; 
    $countryPattern = "/^[A-Za-z\s]{2,}$/"; 

    // Check username
    if (!preg_match($namePattern, $name)) {
        header("location:../html/register.php?nameError=Name must be only English letters with at least 3 letters.");
        exit();
    }

    // Check email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("location:../html/register.php?emailError=Invalid email format.");
        exit();
    }

    // Check password
    if ($password != $confirmpass) {
        header("location:../html/register.php?passError=Passwords do not match.");
        exit();
    }

    // Check if password is strong enough
    if (strlen($password) < 8 || !preg_match("/[A-Z]/", $password) || !preg_match("/[a-z]/", $password) || !preg_match("/[0-9]/", $password)) {
        header("location:../html/register.php?passError=Password must be at least 8 characters long and include uppercase, lowercase, and a number.");
        exit();
    }

    // Check phone number
    if (!preg_match($phonePattern, $phonenumber)) {
        header("location:../html/register.php?phoneError=Invalid phone number. Must be between 10 and 15 digits.");
        exit();
    }

    // Check city, state, country
    if (!preg_match($cityPattern, $city)) {
        header("location:../html/register.php?cityError=City must be at least 2 letters.");
        exit();
    }
    if (!preg_match($statePattern, $state)) {
        header("location:../html/register.php?stateError=State must be at least 2 letters.");
        exit();
    }
    if (!preg_match($countryPattern, $country)) {
        header("location:../html/register.php?countryError=Country must be at least 2 letters.");
        exit();
    }

    // Hash the password securely using password_hash()
    $hashpassword = password_hash($password, PASSWORD_BCRYPT);

    // Prepare SQL query to prevent SQL injection
    $stmt = $db->conn->prepare("INSERT INTO users (first_name, last_name, phone_number, city, state, country, username, email, password) VALUES (:first_name, :last_name, :phone_number, :city, :state, :country, :username, :email, :password)");
    $stmt->bindParam(':first_name', $firstname);
    $stmt->bindParam(':last_name', $lastname);
    $stmt->bindParam(':phone_number', $phonenumber);
    $stmt->bindParam(':city', $city);
    $stmt->bindParam(':state', $state);
    $stmt->bindParam(':country', $country);
    $stmt->bindParam(':username', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashpassword);

    $stmt->execute();
    header("location:../html/register.php?success=You have registed successfully.");
}

if (isset($_POST['loginform'])) {
    $loginemail = htmlspecialchars(trim($_POST['loginemail']));
    $loginpass = $_POST['loginpass']; // Get the plain text password
    
    $stmt2 = $db->conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt2->bindParam(':email', $loginemail);
    $stmt2->execute();
    $result = $stmt2->fetch(PDO::FETCH_ASSOC);

    if ($result && password_verify($loginpass, $result['password'])) {
        session_start();
        $_SESSION['id'] = $result['user_id'];
        $_SESSION['username'] = $result['username'];
        $_SESSION['email'] = $result['email'];
        header("Location: ../html/home.php");
    } else {
        header("Location: ../html/login.php?loginError=Invalid email or password. Please try again.");
        exit();
    }
}


