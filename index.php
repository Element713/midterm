<?php
// Set CORS headers for all origins
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$database = new Database();
$db = $database->connect();

// Handle pre-flight CORS requests (OPTIONS)
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

// Instantiate Database class and connect
include_once '../../config/Database.php';



// Handle other request methods, for example, GET
if ($method === 'GET') {
    // Sample response data (could be replaced by actual DB query)
    $data = array(
        'status' => 'success',
        'message' => 'This is a GET request response.',
        'method' => 'GET',
        'data' => array('example' => 'value') // Replace with actual data from DB
    );

    // Return the response as JSON
    echo json_encode($data);
}



?>
