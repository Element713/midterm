<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Author.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate author object
$author = new Author($db);

// Get ID
$author->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get author details
if ($author->read_single()) {
    // Create array
    $author_array = array(
        'id' => $author->id,
        'author' => $author->author 
    );

    // Make JSON
    echo json_encode($author_array);
} else {
    // If no author found
    echo json_encode(array('message' => 'author_id Not Found'));
}
?>