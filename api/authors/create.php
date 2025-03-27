<?php
// Headers ON THEIR OWN LINES, IF SPLIT TO SECOND LINE IT WILL NOT WORK
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();

$author = new Author($db);

// Get that data
$data = json_decode(file_get_contents("php://input"));

// Check ID
if (!isset($data->author)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit();
}

// Set author details
$author->author = $data->author;

// Create 
if ($author->create()) {
    echo json_encode(array(
        'id' => $author->id, 
        'author' => $author->author
    ));
} else {
    echo json_encode(array('message' => 'author_id Not Found'));
}
?>