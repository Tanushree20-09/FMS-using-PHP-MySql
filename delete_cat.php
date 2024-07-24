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

$id = $conn->real_escape_string($input['id']);

$sql = "DELETE FROM categories WHERE id = '$id'";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
}

$conn->close();
?>
