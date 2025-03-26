<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Enable error reporting (REMOVE IN PRODUCTION)
error_reporting(E_ALL);
ini_set('display_errors', 1);


include_once '../../config/Database.php';
include_once '../../models/Category.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate category object
$category = new Category($db);

// Get ID from URL
$category->id = isset($_GET['id']) ? $_GET['id'] : die(json_encode(['message' => 'Missing ID']));

// Fetch category data
if ($category->read_single()) {
    // Category found, return JSON
    echo json_encode([
        'id' => $category->id,
        'category' => $category->category
    ]);
} else {
    // Category not found, return 404
    http_response_code(404);
    echo json_encode(['message' => 'category_id Not Found']);
}
?>