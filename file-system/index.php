<?php
require_once 'connection.php';
$db=new connection();
$db->connect();
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo "Post request method required";
}
if ($_FILES["image"]["error"] != UPLOAD_ERR_OK) {
    switch ($_FILES["image"]["error"]) {
        case UPLOAD_ERR_PARTIAL:
            exit("file only partially uploaded");
            break;
        case UPLOAD_ERR_NO_FILE:
            exit("no file uploaded");
            break;
        case UPLOAD_ERR_EXTENSION:
            exit("unknown extension");
            break;
            default:
            exit("unknown error");
            break;    
    }
}
$pathinfo=pathinfo($_FILES["image"]["name"]);
$base=$pathinfo["filename"];
$base=preg_replace("/[^\w-]/","_",$base);
$filename=$base.".".$pathinfo["extension"];

$imagedata=file_get_contents($_FILES["image"]["tmp_name"]);
try{
    $qurey="insert into users (name, picture) VALUES (:name,:picture)";
    $stmt=$db->conn->prepare($qurey);
    $stmt->bindParam(':name', $filename);
    $stmt->bindParam(':picture', $imagedata, PDO::PARAM_LOB);
    $stmt->execute();

    echo "Image successfully uploaded and inserted into the database";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

