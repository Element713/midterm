<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate category object
$category = new Category($db);

// Get raw category data
$data = json_decode(file_get_contents("php://input"));

// Validate JSON input
if (!$data) {
    http_response_code(400); // Bad Request
    echo json_encode(array('message' => 'Invalid JSON input'));
    exit();
}

// Validate required field
if (!isset($data->category) || empty(trim($data->category))) {
    http_response_code(400);
    echo json_encode(array('message' => 'Missing Required Field: category'));
    exit();
}

// Set category name
$category->category = htmlspecialchars(strip_tags($data->category)); // Sanitize input

// Create category
if ($category->create()) {
    http_response_code(201); // Created
    echo json_encode(array('message' => 'Category Created'));
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(array('message' => 'Category Not Created - Database Error'));
}
?>