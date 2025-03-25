<?php
// Include database and Quote class files
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate Quote object
$quote = new Quote($db);

// Read quotes from database
$stmt = $quote->read();  // This should return a PDO statement

// Check if any quotes were found
if ($stmt && $stmt->rowCount() > 0) {
    // Prepare the quotes array
    $quotes_arr = array();
    $quotes_arr['data'] = array();

    // Fetch all quotes
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $quote_item = array(
            'id' => $row['id'],
            'quote' => $row['quote'],
            'author_name' => $row['author_name'],
            'category_name' => $row['category_name']
        );

        // Push to quotes data array
        array_push($quotes_arr['data'], $quote_item);
    }

    // Return the result as JSON
    echo json_encode($quotes_arr);
} else {
    // No quotes found
    echo json_encode(
        array('message' => 'No quotes found.')
    );
}
?>