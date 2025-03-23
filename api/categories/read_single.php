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
if (!isset($category->name)) {
    // No category found, return 404 response
    http_response_code(404);
    echo json_encode(array('message' => 'Category Not Found'));
    exit;
}

// Create category array
$category_array = array(
    'id' => $category->id, 
    'name' => $category->name
);

// Convert to JSON and output
echo json_encode($category_array);
?>