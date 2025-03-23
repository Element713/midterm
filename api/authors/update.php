<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,
Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Author.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog author object
$author = new Author($db);

// Get raw author data
$data = json_decode(file_get_contents("php://input"));

// Check if the required fields are set
if (!isset($data->id) || !isset($data->name)) {
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );
    exit();
}

// Set ID to be updated
$author->id = $data->id;
$author->name = $data->name; // Assuming you want to update the 'name' of the author

// Update author
if ($author->update()) {
    echo json_encode(
        array('message' => 'Author Updated')
    );
} else {
    echo json_encode(
        array('message' => 'Author Not Updated')
    );
}
?>