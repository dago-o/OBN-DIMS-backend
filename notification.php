<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include 'connection.php';

$data = json_decode(file_get_contents("php://input"), true);

// Optional: Only fetch where not yet assigned
$sql = "SELECT * FROM issue_reports ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->execute();

$result = $stmt->get_result();
$issues = [];

while ($row = $result->fetch_assoc()) {
    $issues[] = $row;
}

echo json_encode($issues);

$stmt->close();
$conn->close();
?>
