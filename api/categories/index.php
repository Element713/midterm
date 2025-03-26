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
include_once '../../models/Category.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate category object
$category = new Category($db);

// Handle different HTTP methods
switch ($method) {
    case 'GET':
        // If there's an ID in the query string, fetch the single category
        if (isset($_GET['id'])) {
            include_once 'read_single.php'; // Fetch single category
        } else {
            include_once 'read.php'; // Fetch all categories
        }
        break;
    
    case 'POST':
        include_once 'create.php'; // Create a new category
        break;

    case 'PUT':
        include_once 'update.php'; // Update an existing category
        break;
    
    case 'DELETE':
        include_once 'delete.php'; // Delete a category
        break;

    default:
        echo json_encode(array('message' => 'Method Not Allowed'));
        break;
}
?>