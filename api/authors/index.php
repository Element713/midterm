<?php
header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    }
    
include_once '../../config/Database.php';
include_once '../../models/Author.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate author object
$author = new Author($db);

// Handle different HTTP methods
switch ($method) {
    case 'GET':
        // If there's an ID in the query string, fetch the single author
        if (isset($_GET['id'])) {
            include_once 'read_single.php'; // Fetch single author
        } else {
            include_once 'read.php'; // Fetch all authors
        }
        break;
    
    case 'POST':
        include_once 'create.php'; // Create a new author
        break;

    case 'PUT':
        include_once 'update.php'; // Update an existing author
        break;
    
    case 'DELETE':
        include_once 'delete.php'; // Delete an author
        break;

    default:
        echo json_encode(array('message' => 'Method Not Allowed'));
        break;
}
?>