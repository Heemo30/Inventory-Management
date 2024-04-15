<?php
require('../connect.php');


$stmt = $conn->prepare("UPDATE prodact SET Number = Number + ?, DeadNumber = DeadNumber + ? WHERE ID = ?");
$stmt->bind_param("iis", $add, $deadnumber, $productId);

$productId = $_POST['productId'];
$add = $_POST['add'];
$deadnumber = $_POST['deadnumber'];
$stmt->execute();

echo "Number and DeadNumber updated successfully";

$stmt->close();
$conn->close();
?>
