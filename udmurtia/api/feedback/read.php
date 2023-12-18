<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/database.php";
include_once "../objects/feedback.php";

$database = new Database();
$db = $database->getConnection();
$apiKey = $database->apiKey;

if($_GET['apiKey'] != $apiKey) {

    http_response_code(403);
    echo json_encode(array("message" => "Access is denied"), JSON_UNESCAPED_UNICODE);
    return false;
    exit();
}

$feedback = new Feedback($db);
$stmt = $feedback->read();
$num = $stmt->rowCount();

if ($num > 0) {

    $feedbacks_arr = array();
    $feedbacks_arr["feedbacks"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $feedback_item = array(
            "id" => $id,
            "title" => $title,
            "message" => $message,
            "email" => $email,
            "phone_number" => $phone_number,

        );
        array_push($feedbacks_arr["feedbacks"], $feedback_item);
    }

    http_response_code(200);
    echo json_encode($feedbacks_arr);
} else {
    http_response_code(403);
    echo json_encode(array("message" => "feedbacks not found"), JSON_UNESCAPED_UNICODE);
}
?>
