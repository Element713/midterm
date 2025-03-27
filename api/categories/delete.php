<?php


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