<?php
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
if ($method === 'GET' && preg_match('/\/$catagories/', $request_uri)) {
    echo json_encode(["catagories" => ["catagories 1", "catagories 2", "catagories 3"]]);
} elseif ($method === 'POST' && preg_match('/\/$catagories/', $request_uri)) {
    echo json_encode(["message" => "catagories added successfully"]);
} else {
    http_response_code(404);
    echo json_encode(["message" => "Route not found catagories"]);
}
?>
