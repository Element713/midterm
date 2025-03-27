<?php


$category = new Category($db);

$category->id = isset($_GET['id']) ? $_GET['id'] : die();

$category->read_single();

if ($category->read_single()) {
    echo json_encode(array(
        'id' => $category->id,
        'category' => $category->category
    ));
} else {
    echo json_encode(array('message' => 'category_id Not Found'));
}
?>