<?php
header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    }
    
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI']; // Get the request path

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

// Define basic routing
if ($method === 'GET' && preg_match('/\/$authors/', $request_uri)) {
    echo json_encode(["authors" => ["authors 1", "authors 2", "authors 3"]]);
} elseif ($method === 'POST' && preg_match('/\/$authors/', $request_uri)) {
    echo json_encode(["message" => "catagories added successfully"]);
} else {
    http_response_code(404);
    echo json_encode(["message" => "Route not found"]);
}
?>