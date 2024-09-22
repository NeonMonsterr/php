<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../html/login.php?loginError=You must log in first.");
    exit();
}

require "../backend/connection.php";

$userId = $_SESSION['id'];

// Function to fetch cart items
function getCartItems($db, $userId) {
    $query = $db->conn->prepare("SELECT o.order_id, oi.product_id, oi.quantity, p.product_name, p.price 
                                  FROM orders o 
                                  JOIN order_items oi ON o.order_id = oi.order_id 
                                  JOIN products p ON oi.product_id = p.product_id 
                                  WHERE o.user_id = :userId AND o.status = 'pending'");
    $query->execute(['userId' => $userId]);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

// Function to update item quantities
function updateItemQuantities($db, $userId, $quantities) {
    foreach ($quantities as $productId => $newQuantity) {
        $updateItem = $db->conn->prepare("UPDATE order_items 
                                           SET quantity = :quantity 
                                           WHERE order_id = (SELECT order_id FROM orders WHERE user_id = :userId AND status = 'pending') 
                                           AND product_id = :productId");
        $updateItem->execute(['quantity' => $newQuantity, 'userId' => $userId, 'productId' => $productId]);
    }
}

// Function to checkout
function checkout($db, $userId) {
    $updateOrder = $db->conn->prepare("UPDATE orders SET status = 'shipped' WHERE user_id = :userId AND status = 'pending'");
    return $updateOrder->execute(['userId' => $userId]);
}

// Handle form submissions
$confirmationMessage = "";
$orderItems = getCartItems($db, $userId);
$totalPrice = array_reduce($orderItems, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_quantity']) && !empty($_POST['quantities'])) {
        updateItemQuantities($db, $userId, $_POST['quantities']);
        $confirmationMessage = "Cart updated successfully!";
        $orderItems = getCartItems($db, $userId); // Refresh order items after update
    } elseif (isset($_POST['checkout'])) {
        if (checkout($db, $userId)) {
            $confirmationMessage = "Thank you for your purchase!";
            $orderItems = []; // Clear the items for confirmation message
        }
    }
}

// Cart item count
$cartCountQuery = $db->conn->prepare("SELECT SUM(quantity) AS total_items FROM order_items oi 
                                        JOIN orders o ON oi.order_id = o.order_id 
                                        WHERE o.user_id = :userId AND o.status = 'pending'");
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
    <style>
        .product-price { font-weight: bold; }
    </style>
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
                <form method="POST">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orderItems as $item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                    <td>
                                        <input type="number" name="quantities[<?php echo htmlspecialchars($item['product_id']); ?>]" 
                                               value="<?php echo htmlspecialchars($item['quantity']); ?>" 
                                               min="1" required 
                                               onchange="updateTotal(this, <?php echo htmlspecialchars($item['price']); ?>)">
                                    </td>
                                    <td class="product-price" id="price-<?php echo htmlspecialchars($item['product_id']); ?>">
                                        $<?php echo htmlspecialchars($item['price']); ?>
                                    </td>
                                    <td class="product-total" id="total-<?php echo htmlspecialchars($item['product_id']); ?>">
                                        $<?php echo htmlspecialchars($item['price'] * $item['quantity']); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="3" class="text-right">Grand Total:</td>
                                <td id="grand-total">$<?php echo htmlspecialchars($totalPrice); ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-center">
                        <button type="submit" name="update_quantity" class="btn btn-warning">Update Quantity</button>
                        <button type="submit" name="checkout" class="btn btn-success">Checkout</button>
                    </div>
                </form>
            <?php endif; ?>

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
    <script>
        function updateTotal(input, price) {
            const quantity = input.value;
            const totalCell = document.getElementById('total-' + input.name.split('[')[1].replace(']', ''));
            const grandTotalCell = document.getElementById('grand-total');
            
            const newTotal = (price * quantity).toFixed(2);
            totalCell.textContent = '$' + newTotal;

            // Update grand total
            let grandTotal = 0;
            document.querySelectorAll('.product-total').forEach(cell => {
                grandTotal += parseFloat(cell.textContent.replace('$', ''));
            });
            grandTotalCell.textContent = '$' + grandTotal.toFixed(2);
        }
    </script>
</body>
</html>
