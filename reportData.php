<?php
// Allow requests from any origin
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include 'connection.php';

$counts = [];
$counts['total_users'] = $conn->query("SELECT COUNT(*) AS count FROM users")->fetch_assoc()['count'];
$counts['total_devices'] = $conn->query("SELECT COUNT(*) AS count FROM devices")->fetch_assoc()['count'];
$counts['open_issues'] = $conn->query("SELECT COUNT(*) AS count FROM issue_reports WHERE status='open'")->fetch_assoc()['count'];
$counts['in_progress_issues'] = $conn->query("SELECT COUNT(*) AS count FROM issue_reports WHERE status='in_progress'")->fetch_assoc()['count'];
$counts['resolved_issues'] = $conn->query("SELECT COUNT(*) AS count FROM issue_reports WHERE status='resolved'")->fetch_assoc()['count'];
$counts['closed_issues'] = $conn->query("SELECT COUNT(*) AS count FROM issue_reports WHERE status='closed'")->fetch_assoc()['count'];
$counts['total_reports'] = $conn->query("SELECT COUNT(*) AS count FROM engineer_reports")->fetch_assoc()['count'];

// Calculate resolution rate
$total_issues = $conn->query("SELECT COUNT(*) AS count FROM issue_reports")->fetch_assoc()['count'];
$total_resolved = $counts['closed_issues'];
$counts['resolution_rate'] = $total_issues > 0 ? round(($total_resolved / $total_issues) * 100, 2) : 0;

// Calculate engineer performance (number of reports + avg resolution time)
$engineer_perf = [];
$engineer_query = $conn->query("
    SELECT 
        engineer_id,
        COUNT(*) AS total_reports,
        AVG(TIMESTAMPDIFF(HOUR, issue_created_at, created_at)) AS avg_resolution_hours
    FROM engineer_reports
    GROUP BY engineer_id
");

while ($row = $engineer_query->fetch_assoc()) {
    $engineer_perf[] = $row;
}

// Issues
$issues = [];
$result = $conn->query("SELECT id, reported_by, name AS device_name, description, status, created_at FROM issue_reports ORDER BY created_at DESC");
while ($row = $result->fetch_assoc()) {
    $issues[] = $row;
}


$conn->close();
?>
