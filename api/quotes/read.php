<?php



//quote object
$quote = new Quote($db);

$result = $quote->read();

$num = $result->rowCount();

if ($num > 0) {
   
    $quotes_arr = array();

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

    // output 
    echo json_encode($quotes_arr);
} else {
    echo json_encode(array('message' => 'No Quotes Found'));
}
?>