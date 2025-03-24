<?php

// Set CORS headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Include database connection and models
require_once __DIR__ . 'config/Database.php'; 
require_once 'Quote.php';
require_once 'Author.php';
require_once 'Category.php';

// Instantiate database
$database = new Database();
$db = $database->connect();

// Get the HTTP request method
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Check for API route and handle accordingly
if (strpos($uri, '/quotes') === 0) {
    // Route to handle quotes
    $quoteApi = new Quote($db);
    handleQuotes($quoteApi, $method, $uri);
} elseif (strpos($uri, '/authors') === 0) {
    // Route to handle authors
    $authorApi = new Author($db);
    handleAuthors($authorApi, $method, $uri);
} elseif (strpos($uri, '/categories') === 0) {
    // Route to handle categories
    $categoryApi = new Category($db);
    handleCategories($categoryApi, $method, $uri);
} else {
    echo json_encode(['message' => 'Route not found']);
}

// Helper functions to handle different routes
function handleQuotes($quoteApi, $method, $uri) {
    if ($method === 'GET') {
        if (isset($_GET['id'])) {
            $quoteApi->getQuoteById($_GET['id']);
        } elseif (isset($_GET['author_id'])) {
            $quoteApi->getQuotesByAuthorId($_GET['author_id']);
        } elseif (isset($_GET['category_id'])) {
            $quoteApi->getQuotesByCategoryId($_GET['category_id']);
        } else {
            $quoteApi->getAllQuotes();
        }
    } elseif ($method === 'POST') {
        // Handle quote creation
        $quoteApi->createQuote($_POST);
    } elseif ($method === 'PUT') {
        // Handle quote update
        $quoteApi->updateQuote($_PUT);
    } elseif ($method === 'DELETE') {
        // Handle quote deletion
        $quoteApi->deleteQuote($_GET['id']);
    }
}

function handleAuthors($authorApi, $method, $uri) {
    if ($method === 'GET') {
        if (isset($_GET['id'])) {
            $authorApi->getAuthorById($_GET['id']);
        } else {
            $authorApi->getAllAuthors();
        }
    } elseif ($method === 'POST') {
        // Handle author creation
        $authorApi->createAuthor($_POST);
    } elseif ($method === 'PUT') {
        // Handle author update
        $authorApi->updateAuthor($_PUT);
    } elseif ($method === 'DELETE') {
        // Handle author deletion
        $authorApi->deleteAuthor($_GET['id']);
    }
}

function handleCategories($categoryApi, $method, $uri) {
    if ($method === 'GET') {
        if (isset($_GET['id'])) {
            $categoryApi->getCategoryById($_GET['id']);
        } else {
            $categoryApi->getAllCategories();
        }
    } elseif ($method === 'POST') {
        // Handle category creation
        $categoryApi->createCategory($_POST);
    } elseif ($method === 'PUT') {
        // Handle category update
        $categoryApi->updateCategory($_PUT);
    } elseif ($method === 'DELETE') {
        // Handle category deletion
        $categoryApi->deleteCategory($_GET['id']);
    }
}
?>