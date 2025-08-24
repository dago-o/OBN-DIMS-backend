<?php
include 'connection.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: *");

$data = json_decode(file_get_contents("php://input"), true);

$title = $data["title"] ?? null;
$location = $data["location"] ?? null;
$description = $data["description"] ?? null;
$device_id = $data["deviceId"] ?? null;
$reported_by = $data["reportedBy"] ?? null;
$device_name = $data["deviceName"] ?? null;

if ($title && $location && $description && $reported_by && $device_id && $device_name) {
    $sql = "INSERT INTO issue_reports (issue_title, location, description, device_id, reported_by, name)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssiis", $title, $location, $description, $device_id, $reported_by, $device_name);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Issue reported successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to report issue."]);
    }
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "All fields are required."]);
}

$conn->close();
?>
