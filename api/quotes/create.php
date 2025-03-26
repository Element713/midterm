<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,
Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate Quote object
$quote = new Quote($db);

// Get raw quoted data
$data = json_decode(file_get_contents("php://input"));

// Validate input
if (!isset($data->title, $data->body, $data->author, $data->category_id)) {
    http_response_code(400);
    echo json_encode(['message' => 'Missing Required Parameters']);
    exit;
}

// Assign sanitized values
$quote->title = htmlspecialchars(strip_tags($data->title));
$quote->body = htmlspecialchars(strip_tags($data->body));
$quote->author = htmlspecialchars(strip_tags($data->author));
$quote->category_id = htmlspecialchars(strip_tags($data->category_id));

// Create Quote
if ($quote->create()) {
    echo json_encode(['message' => 'Quote Created']);
} else {
    echo json_encode(['message' => 'Quote Not Created']);
}
?>