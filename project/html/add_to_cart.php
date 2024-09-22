<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../html/login.php?loginError=You must log in first.");
    exit();
}

require "../backend/connection.php";

$userId = $_SESSION['id'];
$productId = $_GET['product_id'] ?? null;

if ($productId) {

    $orderQuery = $db->conn->prepare("SELECT order_id FROM orders WHERE user_id = :userId AND status = 'pending'");
    $orderQuery->execute(['userId' => $userId]);
    $order = $orderQuery->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        $insertOrder = $db->conn->prepare("INSERT INTO orders (user_id, total, status, order_date) VALUES (:userId, 0, 'pending', NOW())");
        $insertOrder->execute(['userId' => $userId]);
        $orderId = $db->conn->lastInsertId();
    } else {
        $orderId = $order['order_id'];
    }

    $itemQuery = $db->conn->prepare("SELECT quantity FROM order_items WHERE order_id = :orderId AND product_id = :productId");
    $itemQuery->execute(['orderId' => $orderId, 'productId' => $productId]);
    $item = $itemQuery->fetch(PDO::FETCH_ASSOC);

    if ($item) {

        $newQuantity = $item['quantity'] + 1; 
        $updateItem = $db->conn->prepare("UPDATE order_items SET quantity = :quantity WHERE order_id = :orderId AND product_id = :productId");
        $updateItem->execute(['quantity' => $newQuantity, 'orderId' => $orderId, 'productId' => $productId]);
    } else {

        $productQuery = $db->conn->prepare("SELECT price FROM products WHERE product_id = :productId");
        $productQuery->execute(['productId' => $productId]);
        $product = $productQuery->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            $insertItem = $db->conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:orderId, :productId, 1, :price)");
            $insertItem->execute(['orderId' => $orderId, 'productId' => $productId, 'price' => $product['price']]);
        }
    }

    header("Location: shop.php");
    exit();
} else {
    header("Location: shop.php?error=Product ID is missing.");
    exit();
}
?>