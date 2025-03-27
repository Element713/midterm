<?php
// Headers ON THEIR OWN LINES, IF SPLIT TO SECOND LINE IT WILL NOT WORK
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

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