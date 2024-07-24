<?php
header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

$name = $conn->real_escape_string($input['name']);

$sql = "INSERT INTO categories (name) VALUES ('$name')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
}

$conn->close();
?>

