<?php

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