<?php


//object
$category = new Category($db);

// get data
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->category)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit();
}
$category->category = $data->category;

// Create 
if ($category->create()) {
    echo json_encode(array(
        'id' => $category->id, 
        'category' => $category->category
    ));
} else {
    echo json_encode(array('message' => 'category_id Not Found'));
}
?>