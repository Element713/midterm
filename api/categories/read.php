<?php
// Include database and category class files
include_once '../../config/Database.php';
include_once '../../models/Category.php';

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate category object
$category = new category($db);

// Read categorys from database
$stmt = $category->read();  // This should return a PDO statement

// Check if any categorys were found
if ($stmt && $stmt->rowCount() > 0) {
    // Prepare the categorys array
    $category_arr = array();
    $category_arr['data'] = array();

    // Fetch all categorys
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $category_item = array(
            'id' => $row['id'],
            'category' => $row['category'],
            'author_name' => $row['author_name'],
            'category_name' => $row['category_name']
        );

        // Push to categorys data array
        array_push($category_arr['data'], $category_item);
    }

    // Return the result as JSON
    echo json_encode($category_arr);
} else {
    // No categorys found
    echo json_encode(
        array('message' => 'No category found.')
    );
}
?>