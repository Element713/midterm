<?php
// Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog quote object
    $quote = new Quote($db);

    //Get ID
    $quote->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get quote
    $quote->read_single();

    // Create array
    $quote_array = array(
        'id' => $quote->id, 
        'title' => $quote->title,
        'body' => $quote->body,
        'author' => $quote->author,
        'category_id' => $quote->category_id,
        'category_name' => $quote->category_name,
    );

    // Make JSON
    print_r(json_encode($quote_array));

    ?>