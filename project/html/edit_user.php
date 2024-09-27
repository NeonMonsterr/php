<?php
session_start();
require '../backend/connection.php'; // Make sure this file sets up $db correctly

// Check if the user is logged in and has the necessary permissions
if (!isset($_SESSION['id']) || $_SESSION['role'] != "owner") {
    header("Location: ../html/login.php?loginError=You must log in first.");
    exit();
}

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);

    $stmt = $db->conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        header("Location: Owner.php?error=User not found");
        exit();
    }
} else {
    header("Location: Owner.php?error=No user ID provided");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone_number = isset($_POST['phone_number']) ? trim($_POST['phone_number']) : '';
    $role = isset($_POST['role']) ? trim($_POST['role']) : '';
    $country = isset($_POST['country']) ? trim($_POST['country']) : '';
    $state = isset($_POST['state']) ? trim($_POST['state']) : '';
    $city = isset($_POST['city']) ? trim($_POST['city']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Validate role
    $valid_roles = ['customer', 'owner', 'admin'];
    if (!in_array($role, $valid_roles)) {
        $error = "Invalid role selected.";
    } else {
        // Update the user details in the database
        $stmt = $db->conn->prepare("UPDATE users SET username = ?, email = ?, phone_number = ?, role = ?, country = ?, state = ?, city = ?, password = ? WHERE user_id = ?");

        // Hash the password if it is set
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $hashed_password = $user['password']; // Retain the old password if no new one is set
        }

        if ($stmt->execute([$username, $email, $phone_number, $role, $country, $state, $city, $hashed_password, $user_id])) {
            // Redirect to admin page with success message
            header("Location: Owner.php?success=User updated successfully");
            exit();
        } else {
            // Handle error if update fails
            $error = "Error updating user.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Edit User</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>" required>
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <select class="form-control" id="role" name="role" required>
                <option value="customer" <?php echo ($user['role'] == 'customer') ? 'selected' : ''; ?>>Customer</option>
                <option value="admin" <?php echo ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                <option value="owner" <?php echo ($user['role'] == 'owner') ? 'selected' : ''; ?>>Owner</option>
            </select>
        </div>
        <div class="form-group">
            <label for="country">Country</label>
            <input type="text" class="form-control" id="country" name="country" value="<?php echo htmlspecialchars($user['country']); ?>" required>
        </div>
        <div class="form-group">
            <label for="state">State</label>
            <input type="text" class="form-control" id="state" name="state" value="<?php echo htmlspecialchars($user['state']); ?>" required>
        </div>
        <div class="form-group">
            <label for="city">City</label>
            <input type="text" class="form-control" id="city" name="city" value="<?php echo htmlspecialchars($user['city']); ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password (leave blank to keep unchanged)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Update User</button>
            <a href="Owner.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
