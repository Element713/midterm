<?php
header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    }
    
// Include necessary files
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$quote = new Quote($db);

// Handle different HTTP methods
switch ($method) {
    case 'GET':
        // If there's an ID in the query string, fetch the single quote
        if (isset($_GET['id'])) {
            include_once 'read_single.php'; // Fetch single quote
        } else {
            include_once 'read.php'; // Fetch all quotes
        }
        break;
    
    case 'POST':
        include_once 'create.php'; // Create a new quote
        break;

    case 'PUT':
        include_once 'update.php'; // Update an existing quote
        break;
    
    case 'DELETE':
        include_once 'delete.php'; // Delete a quote
        break;

    default:
        echo json_encode(array('message' => 'Method Not Allowed'));
        break;
}
?>