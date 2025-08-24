<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include 'connection.php';
$sql = "SELECT * FROM announcements ORDER BY created_at DESC";

$result = $conn->query($sql);
$announcements = [];
while ($row = $result->fetch_assoc()) {
    $announcements[] = $row;
}
echo json_encode($announcements);
$conn->close();

?>