<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: *");

include 'connection.php';

$data = json_decode(file_get_contents("php://input"), true);

$user_id = $data["user_id"] ?? null;

if (!$user_id) {
    echo json_encode(["success" => false, "message" => "User ID missing"]);
    exit;
}

$stmt = $conn->prepare("SELECT * FROM issue_reports WHERE reported_by = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$issues = [];
while ($row = $result->fetch_assoc()) {
    $issues[] = $row;
}

if (empty($issues)) {
    echo json_encode([]);
} else {
    echo json_encode($issues);
}

$stmt->close();
$conn->close();
?>
