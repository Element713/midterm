<?php
// Headers ON THEIR OWN LINES, IF SPLIT TO SECOND LINE IT WILL NOT WORK
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


include_once '../../models/Author.php';

// DB Stuff
$database = new Database();
$db = $database->connect();

$author = new Author($db);

// Get ID
$author->id = isset($_GET['id']) ? $_GET['id'] : die();

if ($author->read_single()) {
    $author_array = array(
        'id' => $author->id,
        'author' => $author->author 
    );

    // json output (array)
    echo json_encode($author_array);
} else {
    
    echo json_encode(array('message' => 'author_id Not Found'));
}
?>