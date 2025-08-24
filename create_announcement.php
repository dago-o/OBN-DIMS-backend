<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: *");
include 'connection.php';
$data = json_decode(file_get_contents("php://input"), true);
$title = $data["title"] ?? null;
$content = $data["content"] ?? null;

if ($title && $content) {
    $sql = "INSERT INTO announcements (title, message) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $title, $content);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Announcement created successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to create announcement."]);
    }
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "All fields are required."]);
}
$conn->close();

?>