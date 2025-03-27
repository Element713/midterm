<?php

$author = new Author($db);

// Get data
$data = json_decode(file_get_contents("php://input"));

// Check id
if (!isset($data->id)) {
    echo json_encode(array('message' => 'No Authors Found'));
    exit();
}

// Set details
$author->id = $data->id;

// Delete 
if ($author->delete()) {
    echo json_encode(array('id' => $author->id));
} else {
    echo json_encode(array('message' => 'No Authors Found'));
}
?>