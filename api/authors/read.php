<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Include database and author files
include_once '../../config/Database.php';
include_once '../../models/Author.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate author object
$author = new Author($db);

// Fetch all authors
$result = $author->read();

// Check if the result is valid and has rows
if ($result && $result->rowCount() > 0) {
    // Initialize the array for authors
    $authors_arr = array();
    $authors_arr['data'] = array();

    // Fetch authors
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        // Extract data from the row
        extract($row);

        // Create author item
        $author_item = array(
            'id' => $id,
            'author' => $author 
        );

        // Push to "data" array
        array_push($authors_arr['data'], $author_item);
    }

    // Return authors in JSON format
    echo json_encode($authors_arr);
} else {
    // No authors found
    echo json_encode(
        array('message' => 'No Authors Found')
    );
}
?>