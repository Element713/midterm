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

// Get ID from URL
$category->id = isset($_GET['id']) ? $_GET['id'] : die();

// Fetch category data
$category->read_single();

// Get category details
if ($category->read_single()) {
    echo json_encode(array(
        'id' => $category->id,
        'category' => $category->category
    ));
} else {
    echo json_encode(array('message' => 'category_id Not Found'));
}
?>