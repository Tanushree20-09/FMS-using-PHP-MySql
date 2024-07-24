
<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "fms");

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

$categoriesQuery = "SELECT id, name FROM categories";
$categoriesResult = $conn->query($categoriesQuery);

$categories = array();

while ($category = $categoriesResult->fetch_assoc()) {
    $categoryId = $category['id'];
    $subcategoriesQuery = "SELECT id, name FROM subcategories WHERE category_id = $categoryId";
    $subcategoriesResult = $conn->query($subcategoriesQuery);

    $subcategories = array();
    while ($subcategory = $subcategoriesResult->fetch_assoc()) {
        $subcategories[] = $subcategory;
    }

    $category['subcategories'] = $subcategories;
    $categories[] = $category;
}

echo json_encode($categories);

$conn->close();
?>
