<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <style>
        table {
            border-collapse: collapse; /* Ensures borders are merged */
            width: 100%; /* Makes the table take full width */
        }
        th, td {
            border: 1px solid black; /* Border for table cells */
            padding: 8px; /* Adds padding for better spacing */
            text-align: left; /* Aligns text to the left */
        }
    </style>
</head>
<body>

<h1>User List</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Picture</th>
    </tr>
<?php 
require_once "connection.php";
$db=new connection();
$db->connect();
$qurey="select * from users";
$stmt=$db->conn->prepare($qurey);
$stmt->execute();
$results=$stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($results as $row){
  echo "<tr>";
  echo "<td>".htmlspecialchars($row['id'])."</td>";
  echo "<td>".htmlspecialchars($row['name'])."</td>";
  echo "<td><img src='data:image/jpeg;base64," . base64_encode($row['picture']) . "' alt='Image' width='100' /></td>"; 
  echo "</tr>";
}
?>
</table>

</body>
</html>
