<?php
require "../backend/connection.php";
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] != "owner") {
    header("Location: ../html/login.php?loginError=You must log in first.");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['user_id'];
    
    if (isset($_POST['action']) && $_POST['action'] === 'unban') {
        $stmt = $db->conn->prepare("UPDATE users SET is_banned = 0, ban_reason = NULL, ban_untill = NULL WHERE user_id = :userId");
        $stmt->execute([':userId' => $userId]);

        header("Location: ../html/Owner.php");
        exit();
    } else {
        $banReason = $_POST['ban_reason'];
        $banUntil = $_POST['ban_until'];

        $stmt = $db->conn->prepare("UPDATE users SET is_banned = 1, ban_reason = :ban_reason, ban_untill = :ban_until WHERE user_id = :userId");
        $stmt->execute([
            ':ban_reason' => $banReason,
            ':ban_until' => $banUntil,
            ':userId' => $userId
        ]);

        header("Location: ../html/Owner.php");
        exit();
    }
}
