<?php
// Headers ON THEIR OWN LINES, IF SPLIT TO SECOND LINE IT WILL NOT WORK
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');


include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$category = new Category($db);

// get data
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id)) {
    echo json_encode(array('message' => 'No Categories Found'));
    exit();
}

$category->id = $data->id;

// Delete 
if ($category->delete()) {
    echo json_encode(array('id' => $category->id));
} else {
    echo json_encode(array('message' => 'No Categories Found'));
}
?>