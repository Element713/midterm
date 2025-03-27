<?php
// Headers ON THEIR OWN LINES, IF SPLIT TO SECOND LINE IT WILL NOT WORK
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


include_once '../../models/Quote.php';
include_once '../../models/Author.php';
include_once '../../models/Category.php';


$database = new Database();
$db = $database->connect();


$quote = new Quote($db);
$author = new Author($db);
$category = new Category($db);


$data = json_decode(file_get_contents("php://input"));


if (!isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {

    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit();
}

//author_id check
$author->id = $data->author_id;
if (!$author->findById()) {

    echo json_encode(array('message' => 'author_id Not Found'));
    exit();
}

//category_id check
$category->id = $data->category_id;
if (!$category->findById()) {

    echo json_encode(array('message' => 'category_id Not Found'));
    exit();
}
//set details
$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;

// Create quote
if ($quote->create()) {
    echo json_encode(array(
        'id' => $quote->id,
        'quote' => $quote->quote,
        'author_id' => $quote->author_id,
        'category_id' => $quote->category_id
    ));
    
} else {
    echo json_encode(array('message' => 'Quote Not Created'));
    
}
?>