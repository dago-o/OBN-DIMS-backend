<?php
// get_dashboard_counts.php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include 'connection.php';



$response = [
    'total_devices' => 0,
    'users' => ['admin' => 0, 'network_engineer' => 0, 'end_user' => 0],
    'total_issues' => 0,
    'issues_by_status' => [],
    'total_reports' => 0,
    
];

// total devices
$result = $conn->query("SELECT COUNT(*) AS cnt FROM devices");
if ($row = $result->fetch_assoc()) $response['total_devices'] = (int)$row['cnt'];

// users by role
$result = $conn->query("SELECT role, COUNT(*) AS cnt FROM users GROUP BY role");
while ($row = $result->fetch_assoc()) {
    $role = $row['role'];
    $response['users'][$role] = (int)$row['cnt'];
}

// total issues
$result = $conn->query("SELECT COUNT(*) AS cnt FROM issue_reports");
if ($row = $result->fetch_assoc()) $response['total_issues'] = (int)$row['cnt'];

// issues by status
$result = $conn->query("SELECT status, COUNT(*) AS cnt FROM issue_reports GROUP BY status");
$statuses = [];
while ($row = $result->fetch_assoc()) {
    $statuses[$row['status']] = (int)$row['cnt'];
}
$response['issues_by_status'] = $statuses;

// total engineer reports
$result = $conn->query("SELECT COUNT(*) AS cnt FROM engineer_reports");
if ($row = $result->fetch_assoc()) $response['total_reports'] = (int)$row['cnt'];

// Calculate resolution rate
$total_issues = $conn->query("SELECT COUNT(*) AS count FROM issue_reports")->fetch_assoc()['count'];
$total_resolved = $conn->query("SELECT COUNT(*) AS count FROM issue_reports WHERE status='closed'")->fetch_assoc()['count'];
$response['resolution_rate'] = $total_issues > 0 ? round(($total_resolved / $total_issues) * 100, 2) : 0;

echo json_encode($response);

$conn->close();
