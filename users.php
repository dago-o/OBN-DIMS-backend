<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "obn_dims");
if ($conn->connect_error) {
  echo json_encode(["error" => "Connection failed"]);
  exit();
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

$users = [];
while ($row = $result->fetch_assoc()) {
  $users[] = $row;
}

echo json_encode($users);
$conn->close();
?>
