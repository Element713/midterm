<?php

// Error logging
// Enable error logging and save to a file
ini_set('display_errors', 0);  // Prevent errors from showing in the response
ini_set('log_errors', 1);      // Enable error logging
ini_set('error_log', __DIR__ . '/error.log'); // Log errors to error.log in the root


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

require_once __DIR__ . '/config/Database.php';;

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Midterm Example REST API</title>
    <style>
        body {
            background-color: #333;
            color: whitesmoke;
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
        }
    </style>
</head>
<body> 
    <div class="container">
        <h1>Midterm REST API</h1>
        <p>Use this API to fetch quotes, authors, and categories.</p>
        <ul>
            <li>quotes</li>
            <li>authors</li>
            <li>categories</li>
        </ul>
    </div>
</body>
</html>