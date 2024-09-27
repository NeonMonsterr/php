<?php
require "../backend/connection.php";
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] != "owner") {
    header("Location: ../html/login.php?loginError=You must log in first.");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_id'])) {
        $productId = $_POST['product_id'];
        
        $stmt = $db->conn->prepare("DELETE FROM products WHERE product_id = :productId");
        $stmt->execute([':productId' => $productId]);
        
        header("Location: admin_page.php?success_delete_product=Product deleted successfully.");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['user_id'])) {
        $userId = $_POST['product_id'];
        
        $stmt = $db->conn->prepare("DELETE FROM users WHERE user_id = :userId");
        $stmt->execute([':userId' => $userId]);
        
        header("Location: admin_page.php?success_delete_user=user removed successfully.");
        exit();
    }
}
?>
