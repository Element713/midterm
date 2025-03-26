<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Include database and model files
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate Quote object
$quote = new Quote($db);

// Check if `id` is provided in URL
if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit;
}

// Set ID property
$quote->id = isset($_GET['id']) ? $_GET['id'] : die();

// Fetch the single quote
$quote->read_single();

if ($quote->quote) {
    // Convert to JSON
    echo json_encode([
        "id" => $quote->id,
        "quote" => $quote->quote,
        "author_id" => $quote->author_id,
        "category_id" => $quote->category_id
    ]);
} else {
    http_response_code(404);
    echo json_encode(["message" => "Quote Not Found"]);
}
?>