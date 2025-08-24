<?php
// get_recent_issues.php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include 'connection.php';


$sql = "SELECT id, issue_title, location, name AS device_name, reported_by, status, created_at 
        FROM issue_reports 
        ORDER BY created_at DESC";

        $result=$conn->query($sql);

        $issues= [];

while ($row = $result->fetch_assoc()) 
        {
    $issues[] = $row;
        }
echo json_encode($issues);


?>
