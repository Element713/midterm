<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Credentials: true");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

// Load dependencies
require_once 'config/Database.php';

// Establish database connection
$database = new Database();
$db = $database->connect();

// Get request URI without query params
$request_uri = strtok($_SERVER['REQUEST_URI'], '?');
$request_uri = str_replace('/index.php', '', $request_uri); // Remove /index.php if present

// Routing
$routes = [
    '/quotes' => 'routes/Quote.php',
    '/authors' => 'routes/Author.php',
    '/categories' => 'routes/Category.php'
];

if (isset($routes[$request_uri])) {
    if (file_exists($routes[$request_uri])) {
        require $routes[$request_uri];
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Internal Server Error: Route file missing']);
    }
} else {
    http_response_code(404);
    echo json_encode(['message' => 'Endpoint not found']);
}
?>