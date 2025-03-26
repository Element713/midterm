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

// Get raw data from POST request
$data = json_decode(file_get_contents("php://input"));

// Check for missing parameters (except 'id')
if (!isset($data->author)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit();
}

// Set author details
$author->author = $data->author;

// Create author
if ($author->create()) {
    echo json_encode(array('id' => $author->id, 'author' => $author->author));
} else {
    echo json_encode(array('message' => 'author_id Not Found'));
}
?>