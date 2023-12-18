<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/database.php";
include_once "../objects/news.php";

$database = new Database();
$db = $database->getConnection();


$news = new News($db);
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$records_per_page = 5; 


$offset = ($page - 1) * $records_per_page;

$stmt = $news->read($records_per_page, $offset);
$num = $stmt->rowCount();

if ($num > 0) {

    $news_arr = array();
    $news_arr["news"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $new_item = array(
            "id" => $id,
            "title" => $title,
            "description" => html_entity_decode($description),
            "category_id" => $category_id,
            "category_name" => $category_name,
            "start_date" => $start_date,
            "end_date" => $end_date,
            "start_time" => $start_time,
            "images" => json_decode($images), 
            "source_type" => $source_type,
            "source_link" => $source_link,
            "status" => $status,
            "event_id" => $event_id,
            "user_rated" => json_decode($user_rated)
        );
        array_push($news_arr["news"], $new_item);
    }

    http_response_code(200);
    echo json_encode($news_arr);
}
else {
    http_response_code(404);
    echo json_encode(array("message" => "The news will not be found"), JSON_UNESCAPED_UNICODE);
}
?>
