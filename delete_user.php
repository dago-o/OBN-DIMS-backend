<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['id'])) {
  echo json_encode(["error" => "ID is required"]);
  exit();
}

$conn = new mysqli("localhost", "root", "", "obn_dims");
if ($conn->connect_error) {
  echo json_encode(["error" => "Connection failed"]);
  exit();
}

$id = (int)$input['id'];
$sql = "DELETE FROM users WHERE id = $id";

if ($conn->query($sql)) {
  echo json_encode(["success" => true]);
} else {
  echo json_encode(["error" => $conn->error]);
}

$conn->close();
?>
