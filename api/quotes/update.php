<?php
// Headers ON THEIR OWN LINES, IF SPLIT TO SECOND LINE IT WILL NOT WORK
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';
include_once '../../models/Author.php';
include_once '../../models/Category.php';

//DB stuff
$database = new Database();
$db = $database->connect();

//objects
$quote = new Quote($db);
$author = new Author($db);
$category = new Category($db);

//  raw data
$data = json_decode(file_get_contents("php://input"));
    if (!isset($data->id) || !isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
        echo json_encode(array('message' => 'Missing Required Parameters'));
        exit();
    }

    // check author_id
    $author->id = $data->author_id;
    if (!$author->findById()) {
        echo json_encode(array('message' => 'author_id Not Found'));
        exit();
    }

    //check category_id
    $category->id = $data->category_id;
    if (!$category->findById()) {
        echo json_encode(array('message' => 'category_id Not Found'));
        exit();
    }

    // Check if quote ID
    $quote->id = $data->id;
    if (!$quote->findById()) { 
        echo json_encode(array('message' => 'No Quotes Found'));
        exit();
    }

    // set details
    $quote->id = $data->id;
    $quote->quote = $data->quote;
    $quote->author_id = $data->author_id;
    $quote->category_id = $data->category_id;

    // Update 
    if ($quote->update()) {
        echo json_encode(array('id' => $quote->id, 'quote' => $quote->quote, 'author_id' => $quote->author_id, 'category_id' => $quote->category_id));
    } else {
        echo json_encode(array('message' => 'No Quotes Found'));
    }
    ?>