<?php
   // Headers ON THEIR OWN LINES, IF SPLIT TO SECOND LINE IT WILL NOT WORK
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    
    include_once '../../models/Author.php';

    $database = new Database();
    $db = $database->connect();

    $author = new Author($db);
    $result = $author->read();
    $num = $result->rowCount();

    if ($num > 0) {
        $authors_arr = [];
    
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $authors_arr[] = array(
                'id' => $id,
                'author' => $author 
            );
        }

        echo json_encode($authors_arr);
    } else {
        echo json_encode(
            array('message' => 'No Authors Found')
        );
        }
    
?>