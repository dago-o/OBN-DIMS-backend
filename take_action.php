<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include 'connection.php'; 

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id']) || !isset($data['assigned_engineer_id'])) {
    echo json_encode(["error" => "Missing issue ID or engineer ID"]);
    exit;
}

$issue_id = intval($data['id']);
$assigned_engineer_id = intval($data['assigned_engineer_id']);

$sql = "UPDATE issue_reports 
        SET status = 'in_progress', 
            assigned_engineer_id = ? 
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $assigned_engineer_id, $issue_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "Failed to update issue"]);
}

$stmt->close();
$conn->close();
?>
