<?php
// Headers ON THEIR OWN LINES, IF SPLIT TO SECOND LINE IT WILL NOT WORK
header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
exit(); // exit is used to stop the script from running further then it needs to once headers are sent, otherwise it can cause errors.
}
    
include_once '../../config/Database.php';
include_once '../../models/Author.php';

//DB connection
$database = new Database();
$db = $database->connect();

// author object
$author = new Author($db);

switch ($method) {
    case 'GET':
        
        if (isset($_GET['id'])) {
            include_once 'read_single.php'; 
        } else {
            include_once 'read.php'; 
        }
        break;
    case 'POST':
        include_once 'create.php'; 
        break;

    case 'PUT':
        include_once 'update.php'; 
        break;
    
    case 'DELETE':
        include_once 'delete.php'; 
        break;

    default:
        echo json_encode(array('message' => 'Method Not Allowed'));
        break;
}
?>