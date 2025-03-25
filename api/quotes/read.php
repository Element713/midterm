<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate Quote object
$quote = new Quote($db);

// Blog quote query
$result = $quote->read();
// Get row count
$num = $result->rowCount();

// Check if any Quotes exist
if ($num > 0) {
    // Quote array
    $quotes_arr = array();
    $quotes_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $quote_item = array(
            'id' => $id,
            'quote' => html_entity_decode($quote),  
            'author' => $author,                    
            'category' => $category_name,           
            'category_id' => $category_id          
        );

        // Push to "data"
        array_push($quotes_arr['data'], $quote_item);
    }

    // Set response code and output JSON
    http_response_code(200);
    echo json_encode($quotes_arr);
} else {
    // No Quote Found
    http_response_code(404);
    echo json_encode(array('message' => 'No Quotes Found'));
}
?>