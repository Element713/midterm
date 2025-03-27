<?php

    $category = new Category($db);
    
    $data = json_decode(file_get_contents("php://input"));

    // Check parameters
    if (!isset($data->id) || !isset($data->category)) {
        echo json_encode(array('message' => 'Missing Required Parameters'));
        exit();
    }

    // Set details
    $category->id = $data->id;
    $category->category = $data->category;

    // Update category
    if ($category->update()) {
        echo json_encode(array('id' => $category->id, 'category' => $category->category));
    } else {
        echo json_encode(array('message' => 'category_id Not Found'));
}
?>