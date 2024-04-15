<?php
require('fpdf186\fpdf.php');
require('../connect.php');

$sql = "SELECT * FROM prodact";

if (!empty($_POST['productName']) && !empty($_POST['productId'])) {
    $productName = $_POST['productName'];
    $productId = $_POST['productId'];
    $sql .= " WHERE Name = '$productName' AND ID = '$productId'";
} elseif (!empty($_POST['productName'])) {
    $productName = $_POST['productName'];
    $sql .= " WHERE Name = '$productName'";
} elseif (!empty($_POST['productId'])) {
    $productId = $_POST['productId'];
    $sql .= " WHERE ID = '$productId'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',12);
    $pdf->SetFillColor(200, 220, 255);
    $pdf->Cell(40, 10, 'ID', 1, 0, 'C', true);
    $pdf->Cell(60, 10, 'Name', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Number', 1, 0, 'C', true);
    $pdf->Cell(50, 10, 'DeadNumber', 1, 1, 'C', true);
    $pdf->SetFont('Arial', '', 12);
    $rowCounter = 0;
    while ($row = $result->fetch_assoc()) {
        $rowCounter++;
        if ($rowCounter % 2 == 0) {
            $pdf->SetFillColor(230, 230, 230);
        } else {
            $pdf->SetFillColor(255, 255, 255);
        }
        $pdf->Cell(40, 10, $row["ID"], 1, 0, '', true);
        $pdf->Cell(60, 10, isset($row["NAME"]) ? $row["NAME"] : 'N/A', 1, 0, '', true);
        $pdf->Cell(30, 10, isset($row["NUMBER"]) ? $row["NUMBER"] : 'N/A', 1, 0, '', true);
        $pdf->Cell(50, 10, $row["DeadNumber"], 1, 1, '', true);
    }
    ob_clean();
    $pdf->Output();
} else {
    echo "0 results found";
}
$conn->close();
?>
