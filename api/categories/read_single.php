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


// Check if category exists
if ($category->category === null) {
    // No category found, return JSON message but keep HTTP 200 status
    echo json_encode(array('message' => 'category_id Not Found'));
    exit;
}

// Create category array
$category_array = array(
    'id' => $category->id, 
    'category' => $category->category
);

// Convert to JSON and output
echo json_encode($category_array);
?>