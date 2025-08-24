<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$input = json_decode(file_get_contents("php://input"), true);

if (!$input || !isset($input['id'])) {
  echo json_encode(["error" => "Invalid input"]);
  exit();
}

$conn = new mysqli("localhost", "root", "", "obn_dims");
if ($conn->connect_error) {
  echo json_encode(["error" => "Connection failed"]);
  exit();
}

$id = (int)$input['id'];
$name = $conn->real_escape_string($input['name'] ?? '');
$username = $conn->real_escape_string($input['username'] ?? '');
$email = $conn->real_escape_string($input['email'] ?? '');
$phone = $conn->real_escape_string($input['phone'] ?? '');
$role = $conn->real_escape_string($input['role'] ?? '');

if (!$name || !$username || !$email || !$phone || !$role) {
  echo json_encode(["error" => "Missing required fields"]);
  exit();
}

if (!empty($input['password'])) {
  $password = password_hash($input['password'], PASSWORD_DEFAULT);
  $sql = "UPDATE users SET name='$name', username='$username', password='$password',
          email='$email', phone='$phone', role='$role' WHERE id=$id";
} else {
  $sql = "UPDATE users SET name='$name', username='$username',
          email='$email', phone='$phone', role='$role' WHERE id=$id";
}

if ($conn->query($sql)) {
  echo json_encode(["success" => true]);
} else {
  echo json_encode(["error" => $conn->error]);
}

$conn->close();
?>
