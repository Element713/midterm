<?php
// Headers ON THEIR OWN LINES, IF SPLIT TO SECOND LINE IT WILL NOT WORK
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();

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