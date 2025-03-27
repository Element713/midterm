<?php


$author = new Author($db);

$data = json_decode(file_get_contents("php://input"));
if (!isset($data->id) || !isset($data->author)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit();
}
// Set ID 
$author->id = $data->id;
$author->author = $data->author;
// Update 
if ($author->update()) {
    echo json_encode(array('id' => $author->id, 'author' => $author->author));
} else {
    echo json_encode(array('message' => 'author_id Not Found'));
}
?>