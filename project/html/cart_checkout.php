<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../html/login.php?loginError=You must log in first.");
    exit();
}

require "../backend/connection.php";

$userId = $_SESSION['id'];
$orderQuery = $db->conn->prepare("SELECT o.order_id, oi.product_id, oi.quantity, p.product_name, p.price FROM orders o 
                                   JOIN order_items oi ON o.order_id = oi.order_id 
                                   JOIN products p ON oi.product_id = p.product_id 
                                   WHERE o.user_id = :userId AND o.status = 'pending'");
$orderQuery->execute(['userId' => $userId]);
$orderItems = $orderQuery->fetchAll(PDO::FETCH_ASSOC);

$totalPrice = 0;
foreach ($orderItems as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
}

$confirmationMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updateOrder = $db->conn->prepare("UPDATE orders SET status = 'shipped' WHERE user_id = :userId AND status = 'pending'");
    $updateOrder->execute(['userId' => $userId]);

    $confirmationMessage = "Thank you for your purchase!";

    $orderItems = []; 
}

$cartCountQuery = $db->conn->prepare("SELECT SUM(quantity) AS total_items FROM order_items oi JOIN orders o ON oi.order_id = o.order_id WHERE o.user_id = :userId AND o.status = 'pending'");
$cartCountQuery->execute(['userId' => $userId]);
$cartCount = $cartCountQuery->fetch(PDO::FETCH_ASSOC)['total_items'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart and Checkout - VcpRagon</title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">VcpRagon</div>
            <div class="user-info">
                <i class="fas fa-user-circle"></i>
                <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
            </div>
            <div class="cart-icon">
                <i class="fas fa-shopping-cart"></i>
                <span id="cart-count"><?php echo htmlspecialchars($cartCount); ?></span>

            </div>
        </nav>
    </header>

    <section class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">Your Cart</h2>

        <?php if (!empty($confirmationMessage)): ?>
            <div class="alert alert-success text-center"><?php echo htmlspecialchars($confirmationMessage); ?></div>
        <?php endif; ?>

        <?php if (empty($orderItems)): ?>
            <p class="text-center">Your cart is empty.</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orderItems as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td>$<?php echo htmlspecialchars($item['price']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="2" class="text-right">Total:</td>
                        <td>$<?php echo htmlspecialchars($totalPrice); ?></td>
                    </tr>
                </tbody>
            </table>
            <form method="POST" class="text-center">
                <button type="submit" class="btn btn-success">Checkout</button>
            </form>
        <?php endif; ?>

        <!-- Button to return to shop page -->
        <div class="text-center mt-4">
            <a href="shop.php" class="btn btn-primary">Continue Shopping</a>
        </div>
    </div>
</section>


    <footer>
        <p>&copy; 2024 MyWebsite. All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>