<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

include "connection.php";

$name = $_POST['name'];
$model = $_POST['model'];
$serial_number = $_POST['serial_number'];
$location = $_POST['location'];
$id = isset($_POST['id']) ? $_POST['id'] : null;

$image_url = "";

// Upload directories
$uploadDir = "uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Handle image upload if provided
if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
    $imageName = time() . "_" . basename($_FILES['image']['name']);
    $imagePath = $uploadDir . $imageName;
    if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
        $image_url = $imagePath;
    } else {
        echo json_encode(["message" => "Failed to upload image."]);
        exit;
    }
}

// --- EDIT MODE ---
if ($id) {
    // If a new image is uploaded, update image_url, else keep the old one
    if ($image_url !== "") {
        $sql = "UPDATE devices SET name=?, model=?, serial_number=?, location=?, image_url=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $name, $model, $serial_number, $location, $image_url, $id);
    } else {
        $sql = "UPDATE devices SET name=?, model=?, serial_number=?, location=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $name, $model, $serial_number, $location, $id);
    }

    if ($stmt->execute()) {
        echo json_encode(["message" => "Device updated successfully."]);
    } else {
        echo json_encode(["message" => "Error: " . $stmt->error]);
    }
    $stmt->close();
}
// --- ADD MODE ---
else {
    $sql = "INSERT INTO devices (name, model, serial_number, location, image_url)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $model, $serial_number, $location, $image_url);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Device added successfully."]);
    } else {
        echo json_encode(["message" => "Error: " . $stmt->error]);
    }
    $stmt->close();
}

$conn->close();
?>