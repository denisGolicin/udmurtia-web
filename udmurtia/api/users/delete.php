<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../config/database.php";
include_once "../objects/users.php";

$database = new Database();
$db = $database->getConnection();
$user = new Users($db);
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->auth_token) && !empty($data->phone_number)) {

    $user->auth_token = $data->auth_token;
    $user->phone_number = $data->phone_number;

    if(!$user->getNumber()){
        http_response_code(403);
        echo json_encode(array("message" => 'The phone number does not exist'), JSON_UNESCAPED_UNICODE);
        return false;
    } 

    if($user->getStatus() != 'confirmed'){
        http_response_code(403);
        echo json_encode(array("message" => 'The status does not correspond to delete'), JSON_UNESCAPED_UNICODE);
        return false;
    }

    if(!$user->getToken()){
        http_response_code(403);
        echo json_encode(array("message" => "A user with this token was not found"), JSON_UNESCAPED_UNICODE);
        return false;
    } 

    $user->status = 'removed';
    $result = $user->updateStatus();
    if($result){

        http_response_code(200);
        echo json_encode(array("message" => "Account removed"), JSON_UNESCAPED_UNICODE);

        return true;
    } 

    http_response_code(403);
    echo json_encode(array("message" => "Unknown error"), JSON_UNESCAPED_UNICODE);

    return true;
    exit();

}

http_response_code(403);
echo json_encode(array("message" => "Empty data"), JSON_UNESCAPED_UNICODE);
?>