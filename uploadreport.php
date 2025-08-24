<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include 'connection.php'; // Include your database connection file
if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
    exit(0); // Handle CORS preflight
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $targetDir = "uploads/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $response = [];

    if (!isset($_FILES["report"])) {
        echo json_encode(["success" => false, "error" => "No report file received."]);
        exit;
    }

    $fileName = basename($_FILES["report"]["name"]);
    $targetFile = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if ($fileType !== "pdf") {
        echo json_encode(["success" => false, "error" => "Only PDF files are allowed."]);
        exit;
    }

    if (move_uploaded_file($_FILES["report"]["tmp_name"], $targetFile)) {
        // ✅ Get extra POST fields
        $issue_id = $_POST['issue_id'] ?? '';
        $location = $_POST['location'] ?? '';
        $device_id = $_POST['device_id'] ?? '';
        $device_name = $_POST['device_name'] ?? '';
        $reported_by = $_POST['reported_by'] ?? '';
        $engineer_id = $_POST['engineer_id'] ?? '';

       

        if ($conn->connect_error) {
            echo json_encode(["success" => false, "error" => "Database connection failed."]);
            exit;
        }

        // ✅ Prepare and insert record into `engineer_reports`
        $stmt = $conn->prepare("INSERT INTO engineer_reports (issue_id, location, device_id, device_name, reported_by, engineer_id, file, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sssssss", $issue_id, $location, $device_id, $device_name, $reported_by, $engineer_id, $targetFile);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Report uploaded and saved to database."]);
        } else {
            echo json_encode(["success" => false, "error" => "Failed to insert report into database."]);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(["success" => false, "error" => "Failed to move uploaded file."]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid request method."]);
}
?>
