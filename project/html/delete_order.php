<?php
require "../backend/connection.php";
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] != "owner") {
    header("location:home.php");
    exit();
}

if (isset($_POST['order_id'])) {
    $orderId = $_POST['order_id'];

    try {
        // Begin a transaction
        $db->conn->beginTransaction();

        // First, delete order items associated with the order
        $deleteItemsStmt = $db->conn->prepare("DELETE FROM order_items WHERE order_id = :order_id");
        $deleteItemsStmt->execute([':order_id' => $orderId]);

        // Now, delete the order itself
        $deleteOrderStmt = $db->conn->prepare("DELETE FROM orders WHERE order_id = :order_id");
        $deleteOrderStmt->execute([':order_id' => $orderId]);

        // Commit the transaction
        $db->conn->commit();

        $stmt = $db->conn->prepare("SELECT user_id FROM orders WHERE order_id = :order_id");
        $stmt->execute([':order_id' => $orderId]);
        $userId = $stmt->fetchcolumn();

        header("Location: view_orders.php?user_id=$user_id&success=Order deleted successfully.");
        exit();
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        $db->conn->rollBack();
        echo "Error deleting order: " . htmlspecialchars($e->getMessage());
        exit();
    }
} else {
    echo "Invalid request!";
    exit();
}
