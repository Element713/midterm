<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Credentials: true");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

// Load dependencies
require 'vendor/autoload.php';
require_once 'config/database.php';

// Establish database connection
$database = new Database();
$db = $database->connect();

// Handle Routing
$request_uri = strtok($_SERVER['REQUEST_URI'], '?'); // Removes query parameters

switch ($request_uri) {
    case '/quotes':
        require 'routes/quotes.php';
        break;
    case '/authors':
        require 'routes/authors.php';
        break;
    case '/categories':
        require 'routes/categories.php';
        break;
    default:
        http_response_code(404);
        echo json_encode(['message' => 'Endpoint not found']);
        break;
}