<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/database.php";
include_once "../objects/events.php";

$database = new Database();
$db = $database->getConnection();

$event = new Events($db);

$page = isset($_GET['page']) ? $_GET['page'] : 1;

$records_per_page = 5; 
$offset = ($page - 1) * $records_per_page;
$stmt = $event->read($records_per_page, $offset);

$num = $stmt->rowCount();

if ($num > 0) {

    $events_arr = array();
    $events_arr["events"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $event_item = array(
            "id" => $id,
            "title" => $title,
            "description" => html_entity_decode($description),
            "category_id" => $category_id,
            "category_name" => $category_name,
            "start_date" => $start_date,
            "end_date" => $end_date,
            "start_time" => $start_time,
            "venue" => $venue,
            "images" => json_decode($images),
            "district_id" => $district_id,
            "district_name" => $district_name,

            "last_name" => $last_name,
            "first_name" => $first_name,
            "middle_name" => $middle_name,
            "post" => $post, 
            "phone_number" => $phone_number,
            "organization_address" => $organization_address,
            "social_links" => json_decode($social_links),
            "experience" => $experience,
            "currency" => $currency,
            "status" => $status,
            "user_rated" => json_decode($user_rated)
        );
        array_push($events_arr["events"], $event_item);
    }

    http_response_code(200);
    echo json_encode($events_arr);
}
 else {
    http_response_code(404);
    echo json_encode(array("message" => "Мероприятия не найдены."), JSON_UNESCAPED_UNICODE);
}
?>
