<?php
require('../connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $ids = $_POST['id'];
    $names = $_POST['name'];
    $numbers = $_POST['number'];
    $deadNumbers = $_POST['deadNumber'];

    for ($i = 0; $i < count($ids); $i++) {
        $id = $ids[$i];
        $name = $names[$i];
        $number = $numbers[$i];
        $deadNumber = $deadNumbers[$i];

        $updateSql = "UPDATE prodact SET Name=?, Number=?, DeadNumber=? WHERE ID=?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("ssss", $name, $number, $deadNumber, $id);

        if ($stmt->execute()) {
            echo "<script>alert('Record with ID $id updated successfully');</script>";
        } else {
            echo "Error updating record with ID $id: " . $conn->error . "<br>";
        }

        $stmt->close();
    }
}

$sql = "SELECT * FROM prodact";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <link rel="stylesheet" type="text/css" href="TABLE.css">
</head>
<body>

<?php
if ($result->num_rows > 0) {
    echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Name</th><th>Number</th><th>DeadNumber</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row["ID"]}</td>";
        echo "<td><input type='text' name='name[]' value='" . htmlspecialchars($row["NAME"]) . "'></td>";
        echo "<td><input type='text' name='number[]' value='" . htmlspecialchars($row["NUMBER"]) . "'></td>";
        echo "<td><input type='text' name='deadNumber[]' value='" . htmlspecialchars($row["DeadNumber"]) . "'></td>";
        echo "<input type='hidden' name='id[]' value='{$row["ID"]}'>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<input type='submit' name='update' value='Update'>";
    echo "</form>";
} else {
    echo "0 results found";
}

$conn->close();
?>

</body>
</html>
