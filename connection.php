<?php
// Create connection
$conn = new mysqli("localhost", "root", "", "obn_dims");

// Check connection
if ($conn->connect_error) {
    // If there's a connection error, show it and stop execution
    die("❌ Connection failed: " . $conn->connect_error);
} 
//else {
//     echo "✅ Database connection successful!";
// }
?>
