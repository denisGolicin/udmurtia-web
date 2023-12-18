<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$data = json_decode(file_get_contents("php://input"));

include_once "../config/database.php";
include_once "../objects/users.php";
$database = new Database();
$db = $database->getConnection();
$user = new Users($db);

if (!empty($data->number_phone)) {

    $user->phone_number = $data->phone_number;
    $result = $user->auth();
    echo json_encode(array("message" => $result), JSON_UNESCAPED_UNICODE);

} else {

    http_response_code(400);
    echo json_encode(array("message" => "error", "error" => "data empty"), JSON_UNESCAPED_UNICODE);
    
}

?>