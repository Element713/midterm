<?php
// Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,
    Access-Control-Allow-Methods,Authorization,X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog quote object
    $quote = new Quote($db);

    // Get raw quoted data
    $data = json_decode(file_get_contents("php://input"));

    // Validate input data
    if (!isset($data->id, $data->quote, $data->author_id, $data->author, $data->category_id, $data->category)) {
    http_response_code(400);
    echo json_encode(array('message' => 'Missing Required Fields'));
    exit();
    }
    // Set ID to be updated
    $quote->id = $data->id;
    $quote->quote = $data->quote;
    $quote->author_id = $data->author_id;
    $quote->author = $data->author;
    $quote->category_id = $data->category_id;
    $quote->category = $data->category;

    // Update quote
    if ($quote->update()) {
        
        echo json_encode(array('message' => 'Quote Updated'));
    } else {
        
        echo json_encode(array('message' => 'Quote Not Updated'));
}
?>