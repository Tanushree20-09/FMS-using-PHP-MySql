<?php
header('Content-Type: application/json');

// Retrieve and decode JSON input
$input = json_decode(file_get_contents('php://input'), true);

// Database connection details
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

// Retrieve the subcategory ID from input
$subcategoryId = isset($input['id']) ? $conn->real_escape_string($input['id']) : null;

if ($subcategoryId) {
    // Prepare SQL statement to delete the subcategory
    $sql = "DELETE FROM subcategories WHERE id = '$subcategoryId'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid subcategory ID.']);
}

$conn->close();
?>
