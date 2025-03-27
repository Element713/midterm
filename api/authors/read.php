<?php
  

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