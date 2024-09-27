<?php 
require "../backend/connection.php";
session_start();
if(!isset($_SESSION['id'])||($_SESSION['role']!="owner")){
    header("location:home.php");
    exit();
}

if(isset($_REQUEST['user_id']) ){
    $userid = $_REQUEST['user_id']; 
    $stmt = $db->conn->prepare("SELECT * FROM orders WHERE user_id = :user_id");
    $stmt->execute([':user_id' => $userid]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Orders for User ID: <?php echo htmlspecialchars($userid ?? ''); ?></h2>

        <?php if (empty($orders)): ?>
            <p class="text-center">No orders found for this user.</p>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Order Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['order_id'] ?? ''); ?></td>
                            <td>$<?php echo htmlspecialchars($order['total'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($order['status'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars(date('F j, Y', strtotime($order['order_date'] ?? ''))); ?></td>
                            <td>
                                <!-- Edit Order Form -->
                                <form action="edit_order.php" method="post" style="display:inline-block;">
                                    <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id'] ?? ''); ?>">
                                    <button type="submit" class="btn btn-warning">Edit</button>
                                </form>

                                <!-- Delete Order Form -->
                                <form action="delete_order.php" method="post" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this order?');">
                                    <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id'] ?? ''); ?>">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
