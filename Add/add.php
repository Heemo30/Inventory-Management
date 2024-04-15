<?php
require('../connect.php');

$stmt = $conn->prepare("INSERT INTO prodact (ID, Name, Number) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $productId, $productName, $productNumber);

$productId = $_POST['productId'];
$productName = $_POST['productName'];
$productNumber = $_POST['productNumber'];
$stmt->execute();

echo "New record created successfully";

$stmt->close();
$conn->close();
?>
