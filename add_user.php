<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$input = json_decode(file_get_contents("php://input"), true);

if (!$input) {
  echo json_encode(["error" => "Invalid JSON data"]);
  exit();
}

$conn = new mysqli("localhost", "root", "", "obn_dims");
if ($conn->connect_error) {
  echo json_encode(["error" => "Connection failed"]);
  exit();
}

$name = $conn->real_escape_string($input['name'] ?? '');
$username = $conn->real_escape_string($input['username'] ?? '');
$password = password_hash($input['password'] ?? '', PASSWORD_DEFAULT);
$email = $conn->real_escape_string($input['email'] ?? '');
$phone = $conn->real_escape_string($input['phone'] ?? '');
$role = $conn->real_escape_string($input['role'] ?? '');

if (!$name || !$username || !$email || !$phone || !$role || !$input['password']) {
  echo json_encode(["error" => "Missing required fields"]);
  exit();
}

$sql = "INSERT INTO users (name, username, password, email, phone, role)
        VALUES ('$name', '$username', '$password', '$email', '$phone', '$role')";

if ($conn->query($sql)) {
  echo json_encode(["success" => true]);
} else {
  echo json_encode(["error" => $conn->error]);
}

$conn->close();
?>
