<?php


$category = new Category($db);

$result = $category->read();

$num = $result->rowCount();

if ($num > 0) {
    $categories_arr = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $categories_arr[] = array(
            'id' => $id,
            'category' => $category
        );
    }

   //output json array 
    echo json_encode($categories_arr);
} else {
    echo json_encode(array('message' => 'No Categories Found'));
}
?>