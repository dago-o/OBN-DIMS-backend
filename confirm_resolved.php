<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include('connection.php');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id'])) {
    echo json_encode(["error" => "Missing issue ID"]);
    exit;
}

$issue_id = intval($data['id']);

$sql = "UPDATE issue_reports 
        SET status = 'resolved' 
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $issue_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "Failed to confirm resolved"]);
}

$stmt->close();
$conn->close();
?>
