<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Author.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate author object
$author = new Author($db);

// Get raw author data
$data = json_decode(file_get_contents("php://input"));

// Validate JSON input
if (!$data) {
    http_response_code(400); // Bad Request
    echo json_encode(array('message' => 'Invalid JSON input'));
    exit();
}

// Validate required fields
if (!isset($data->name)) {
    http_response_code(400); // Bad Request
    echo json_encode(array('message' => 'Missing Required Field: name'));
    exit();
}

// Sanitize input
$author->name = htmlspecialchars(strip_tags($data->name));

// Create author
if ($author->create()) {
    http_response_code(201); // Created
    echo json_encode(array('message' => 'Author Created'));
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(array('message' => 'Author Not Created - Database Error'));
}
?>