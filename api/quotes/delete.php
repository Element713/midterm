<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,
Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate Quote object
$quote = new Quote($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Validate input
if (!isset($data->id) || empty($data->id)) {
    http_response_code(400);
    echo json_encode(['message' => 'Missing Required ID']);
    exit;
}

// Sanitize ID
$quote->id = htmlspecialchars(strip_tags($data->id));

// Delete quote
if ($quote->delete()) {
    echo json_encode(['message' => 'Quote Deleted']);
} else {
    echo json_encode(['message' => 'Quote Not Deleted']);
}
?>