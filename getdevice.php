<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include "connection.php";

$sql = "SELECT * FROM devices";
$result = $conn->query($sql);

$devices = [];

while ($row = $result->fetch_assoc()) {
    $devices[] = $row;
}

echo json_encode($devices);
?>
