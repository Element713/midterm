<?php
header('Content-Type: application/json');
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

$params = $_GET;
$result = $quote->read($params);
$num = $result->rowCount();

if ($num > 0) {
    $quotes_arr = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $quotes_arr[] = ['id' => $id, 'quote' => $quote, 'author_id' => $author_id, 'category_id' => $category_id];
    }
    echo json_encode($quotes_arr);
} else {
    echo json_encode(["message" => "No Quotes Found"]);
}
?>