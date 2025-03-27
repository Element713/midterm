<?php
// Headers ON THEIR OWN LINES, IF SPLIT TO SECOND LINE IT WILL NOT WORK
header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    }
    
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

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