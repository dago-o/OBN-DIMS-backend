<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: *");
include 'connection.php';

$data = json_decode(file_get_contents("php://input"), true);

$username = $data["username"];
$password = $data["password"];

if ($username && $password) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row["password"])) {
            echo json_encode([
                "success" => true,
                "role" => $row["role"],
                "user_id" => $row["id"]
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Incorrect username or password."
            ]);
        }
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Incorrect username or password."
        ]);
    }

    $stmt->close();
} else {
    echo json_encode([
        "success" => false,
        "message" => "Username and password are required."
    ]);
}

$conn->close();
?>