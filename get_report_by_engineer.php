<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");

include 'connection.php';

$sql = "SELECT 
            er.*, 
            ir.reported_by, 
            ir.created_at AS issue_created_at,
            TIMESTAMPDIFF(MINUTE, ir.created_at, er.created_at) AS resolution_time_minutes
        FROM engineer_reports er
        JOIN issue_reports ir ON er.issue_id = ir.id";

$result = $conn->query($sql);

$reports = [];

while ($row = $result->fetch_assoc()) {
    $row['resolution_time'] = round($row['resolution_time_minutes'] / 60, 2) . ' hrs';
    $reports[] = $row;
}

echo json_encode($reports);
$conn->close();
