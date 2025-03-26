<?php
// Include necessary files
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

// Initialize an empty array
$quotes_arr = array();

// Check if any quotes exist
if ($num > 0) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        
        $quote_item = array(
            'id' => isset($id) ? $id : null,
            'quote' => isset($quote) ? html_entity_decode($quote) : null,
            'author' => isset($author_name) ? $author_name : 'Unknown Author',
            'category' => isset($category_name) ? $category_name : 'Uncategorized'
        );

        array_push($quotes_arr, $quote_item);
    }

    // Set response code to 200 (OK)
    http_response_code(200);
    echo json_encode($quotes_arr);
} else {
    // No Quotes Found - Return an empty array
    http_response_code(404);
    echo json_encode(["message" => "No Quotes Found"]);
}
?>