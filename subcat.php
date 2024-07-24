<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fms"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['categoryId'])) {
    $categoryId = intval($_GET['categoryId']);
    
    // Fetch the category name
    $categorySql = "SELECT name FROM categories WHERE id = ?";
    $categoryStmt = $conn->prepare($categorySql);
    $categoryStmt->bind_param("i", $categoryId);
    $categoryStmt->execute();
    $categoryResult = $categoryStmt->get_result();
    $category = $categoryResult->fetch_assoc();
    
    // Fetch the subcategories
    $subcatSql = "SELECT id, name FROM subcategories WHERE category_id = ?";
    $subcatStmt = $conn->prepare($subcatSql);
    $subcatStmt->bind_param("i", $categoryId);
    $subcatStmt->execute();
    $subcatResult = $subcatStmt->get_result();

    $subcategories = [];
    while ($row = $subcatResult->fetch_assoc()) {
        $subcategories[] = $row;
    }

    $response = [
        'categoryName' => $category['name'],
        'subcategories' => $subcategories
    ];

    echo json_encode($response);
}

$conn->close();
?>
