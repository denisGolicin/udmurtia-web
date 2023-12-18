<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../config/database.php";
include_once "../objects/feedback.php";

$database = new Database();
$db = $database->getConnection();
$feedback = new Feedback($db);
$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->title) &&
    !empty($data->email) &&
    !empty($data->phone_number) &&
    !empty($data->message)
) {

    $feedback->title = $data->title;
    $feedback->email = $data->email;
    $feedback->phone_number = $data->phone_number;
    $feedback->message = $data->message;

    if($feedback->create()){
        http_response_code(200);
        echo json_encode(array("message" => "success"), JSON_UNESCAPED_UNICODE);

        return false;
    }

    http_response_code(403);
    echo json_encode(array("message" => "Error sending data"), JSON_UNESCAPED_UNICODE);

} else {
    http_response_code(403);
    echo json_encode(array("message" => "Empty data"), JSON_UNESCAPED_UNICODE);
}


?>