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
if (!isset($data->id, $data->quote, $data->author, $data->category)) {
    http_response_code(400);
    echo json_encode(['message' => 'Missing Required Parameters']);
    exit;
}

// Assign sanitized values
$quote->id = htmlspecialchars(strip_tags($data->id));
$quote->quote = htmlspecialchars(strip_tags($data->quote));
$quote->author = htmlspecialchars(strip_tags($data->author));
$quote->category = htmlspecialchars(strip_tags($data->category));

// Create Quote
if ($quote->create()) {
    echo json_encode(['message' => 'Quote Created']);
} else {
    echo json_encode(['message' => 'Quote Not Created']);
}
?>