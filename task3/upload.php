<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uploadDir = "uploads/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $uploadFile = $uploadDir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowedTypes)) {
        $error = "Only JPG, JPEG, PNG & GIF files are allowed.";
        header("Location: register.php?error=" . urlencode($error));
        exit();
    }

    if ($_FILES["image"]["size"] > 5000000) {
        $error = "File is too large. Maximum file size is 5MB.";
        header("Location: register.php?error=" . urlencode($error));
        exit();
    }

    if ($_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
        $error = "Upload failed with error code " . $_FILES["image"]["error"];
        header("Location: register.php?error=" . urlencode($error));
        exit();
    }

    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $uploadFile)) {
        $error = "Failed to upload image. Error occurred during file move.";
        header("Location: register.php?error=" . urlencode($error));
        exit();
    }

    $data = [
        'username' => $_POST['username'],
        'image' => $uploadFile
    ];

    $jsonFilePath = 'data.json';

    if (file_exists($jsonFilePath)) {
        $jsonData = file_get_contents($jsonFilePath);
        $dataArr = json_decode($jsonData, true);
    } else {
        $dataArr = [];
    }

    $dataArr[] = $data;

    file_put_contents($jsonFilePath, json_encode($dataArr, JSON_PRETTY_PRINT));

    header("Location: success.php?image=" . urlencode($uploadFile));
    exit();
}
?>
