<?php 
require "../backend/connection.php";
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] != "owner") {
    header("location:home.php");
    exit();
}

$order = null;
$userId = null; // Initialize user ID variable

// Check if the request is to fetch the order
if (isset($_POST['order_id']) && !isset($_POST['update_order'])) {
    $orderId = $_POST['order_id'];

    // Fetch the order details
    $stmt = $db->conn->prepare("SELECT * FROM orders WHERE order_id = :order_id");
    $stmt->execute([':order_id' => $orderId]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch user_id associated with the order
    $stmt = $db->conn->prepare("SELECT user_id FROM orders WHERE order_id = :order_id");
    $stmt->execute([':order_id' => $orderId]);
    $userId = $stmt->fetchcolumn();
    var_dump($userId); 

    if (!$order) {
        echo "Order not found!";
        exit();
    }
}

// Handle updating the order
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_order'])) {
    $orderId = $_POST['order_id'];
    $status = $_POST['status'];

    // Update the order status
    $updateStmt = $db->conn->prepare("UPDATE orders SET status = :status WHERE order_id = :order_id");
    $updateStmt->execute([
        ':status' => $status,
        ':order_id' => $orderId
    ]);
    $stmt = $db->conn->prepare("SELECT user_id FROM orders WHERE order_id = :order_id");
    $stmt->execute([':order_id' => $orderId]);
    $userId = $stmt->fetchcolumn();
    var_dump($userId); 

    // Redirect back to view_orders.php with user_id
    echo $userId;
    header("Location: view_orders.php?user_id=$userId&success=Order updated.");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <?php if ($order): ?>
            <h2>Edit Order #<?php echo htmlspecialchars($order['order_id']); ?></h2>

            <form method="POST">
                <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($userId); ?>"> <!-- Include user_id -->

                <div class="form-group">
                    <label for="status">Order Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="pending" <?php if($order['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                        <option value="shipped" <?php if($order['status'] == 'shipped') echo 'selected'; ?>>Shipped</option>
                        <option value="delivered" <?php if($order['status'] == 'delivered') echo 'selected'; ?>>Delivered</option>
                        <option value="canceled" <?php if($order['status'] == 'canceled') echo 'selected'; ?>>Canceled</option>
                    </select>
                </div>

                <button type="submit" name="update_order" class="btn btn-success">Update Order</button>
            </form>
        <?php else: ?>
            <h2>Select an Order to Edit</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="order_id">Order ID</label>
                    <input type="text" class="form-control" id="order_id" name="order_id" placeholder="Enter Order ID">
                </div>
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($userId); ?>">
                <button type="submit" class="btn btn-primary">Fetch Order</button>
            </form>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
