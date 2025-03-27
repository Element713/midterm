<?php


// Instantiate quote object
$quote = new Quote($db);

$quote->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get quote
if ($quote->id) {
    if ($quote->read_single()) {
        $quote_array = array(
            'id' => $quote->id,
            'quote' => $quote->quote,
            'author' => $quote->author_name,
            'category' => $quote->category_name
        );
        echo json_encode($quote_array);
    } else {
        // Quote not found
        echo json_encode(array('message' => 'No Quotes Found'));
    }
}
?>