<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate category object
$category = new Category($db);

// Category read query
$result = $category->read();
// Get row count
$num = $result->rowCount();

// Check if any categories exist
if ($num > 0) {
    $categories_arr = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $categories_arr[] = array(
            'id' => $id,
            'category' => $category
        );
    }

    // Set response code & output JSON
    echo json_encode($categories_arr);
} else {
    // No Categories Found
    echo json_encode(array('message' => 'No Categories Found'));
}
?>