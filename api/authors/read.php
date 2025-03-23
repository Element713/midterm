<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate author object
    $author = new Author($db);

    // Fetch all authors
    $result = $author->read();
    // Get row count
    $num = $result->rowCount();

    // Check if any authors
    if ($num > 0) {
        // Author array
        $authors_arr = array();
        $authors_arr['data'] = array();

        // Fetch authors
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            // Create author item
            $author_item = array(
                'id' => $id,
                'name' => $name // assuming the column is 'name'
            );

            // Push to "data"
            array_push($authors_arr['data'], $author_item);
        }

        // Turn to JSON & output
        echo json_encode($authors_arr);

    } else {
        // No authors found
        echo json_encode(
            array('message' => 'No Authors Found')
        );
    }
?>