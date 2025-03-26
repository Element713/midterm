<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
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

// Check if ID is provided
if (!isset($data->id) || empty($data->id)) {
    http_response_code(400); // Bad Request
    echo json_encode(array('message' => 'Category ID is required'));
    exit;
}

// Set ID for deletion
$category->id = $data->id;

// Attempt to delete the category
if ($category->delete()) {
    http_response_code(200); // OK
    echo json_encode(array('message' => 'Category Deleted'));
} else {
    http_response_code(404); // Not Found
    echo json_encode(array('message' => 'Category Not Found or Could Not Be Deleted'));
}
?>