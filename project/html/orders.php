<?php
require "../backend/connection.php";
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['id'])) {
    header("Location: ../html/login.php?loginError=You must log in first.");
    exit();
}

// Fetch user orders
$stmt = $db->conn->prepare("SELECT * FROM orders WHERE user_id = :user_id");
$stmt->execute([':user_id' => $_SESSION['id']]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Orders</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Your Orders</h2>

        <?php if (count($orders) > 0): ?>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                            <td><?php echo htmlspecialchars($order['status']); ?></td>
                            <td><?php echo htmlspecialchars($order['total']); ?> USD</td>
                            <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                            <td>

                                <!-- Delete Button -->
                                <form action="delete_order.php" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this order?');">
                                    <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info">
                <strong>No orders found.</strong> You have not placed any orders yet.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
