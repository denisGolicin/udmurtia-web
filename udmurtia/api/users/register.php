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

if (
    !empty($data->phone_number) &&
    !empty($data->first_name) &&
    !empty($data->last_name) &&
    !empty($data->birth_date)
) {

    $user->phone_number = $data->phone_number;
    $user->first_name = $data->first_name;
    $user->last_name = $data->last_name;
    $user->birth_date = $data->birth_date;
    $user->status = 'confirmed';

    if(!$user->getNumber()){
        http_response_code(403);
        echo json_encode(array("message" => "The phone number does not exist"), JSON_UNESCAPED_UNICODE);
        return false;
    }

    if($user->getStatus() != 'being_registered'){
        http_response_code(403);
        echo json_encode(array("message" => 'The status does not correspond to registration'), JSON_UNESCAPED_UNICODE);
        return false;
    }

    if(!$user->register()){

        http_response_code(403);
        echo json_encode(array("message" => 'Registration error'), JSON_UNESCAPED_UNICODE);
        return false;

    }

    http_response_code(200);
    echo json_encode(array("message" => 'The user is registered'), JSON_UNESCAPED_UNICODE);
    return true;
}

if (!empty($data->code) && !empty($data->phone_number)) {

    $user->code = $data->code;
    $user->phone_number = $data->phone_number;

    if(!$user->getNumber()){
        http_response_code(403);
        echo json_encode(array("message" => "The phone number does not exist"), JSON_UNESCAPED_UNICODE);
        return false;
    }

    if($user->getStatus() != 'not_confirm'){
        http_response_code(403);
        echo json_encode(array("message" => 'The status does not correspond to registration'), JSON_UNESCAPED_UNICODE);
        return false;
    }

    $result = $user->getCode();

    if($result != 'not found') {

        if($result != $data->code){
            http_response_code(403);
            echo json_encode(array("message" => "Incorrect code"), JSON_UNESCAPED_UNICODE);
            return false;
        } else {
            // смена статуса, можно заполнять данные
            $user->status = 'being_registered';
            $result = $user->updateStatus();
            if($result){
        
                http_response_code(200);
                echo json_encode(array("message" => "Number confirmed"), JSON_UNESCAPED_UNICODE);

                return true;
            } 
        }
    }

    http_response_code(403);
    echo json_encode(array("message" => 'Unknown error'), JSON_UNESCAPED_UNICODE);
    return false;

} 

if (!empty($data->phone_number)) {

    $user->first_name = isset($data->first_name) ? $data->first_name : "Имя";
    $user->last_name = isset($data->last_name) ? $data->last_name : "Фамилия";
    $user->middle_name = isset($data->middle_name) ? $data->middle_name : "";
    $user->password = isset($data->password) ? $data->password : "";
    $user->email = isset($data->email) ? $data->email : null;
    $user->birth_date = isset($data->birth_date) && !empty($data->birth_date) ? $data->birth_date : '1990-01-15';
    $user->email = $data->email;
    $user->password = $data->password;
    $user->mailing_address = isset($data->mailing_address) ? $data->mailing_address : null;
    $user->event_ids = isset($data->event_ids) ? json_encode($data->event_ids) : "[]";
    $user->profile_photo = isset($data->profile_photo) ? $data->profile_photo : null;
    $user->certificate_photos = isset($data->certificate_photos) ? json_encode($data->certificate_photos) : "[]";
    $user->residence_location = isset($data->residence_location) ? $data->residence_location : null;
    $user->age = isset($data->age) ? $data->age : 0;
    $user->gender = isset($data->gender) ? $data->gender : 'other';
    $user->status = isset($data->status) ? $data->status : "not_confirm";
    $user->user_type = isset($data->user_type) ? $data->user_type : "user";
    $user->balance = isset($data->balance) ? $data->balance : 0;
    $user->phone_number = isset($data->phone_number) ? $data->phone_number : "";
    $user->auth_token = isset($data->auth_token) ? $data->auth_token : "";
    $user->code = isset($data->code) ? $data->code : "222222";
    $user->friends_ids = isset($data->friends_ids) ? json_encode($data->friends_ids) : "[]";
    $user->friend_requests_id = isset($data->friend_requests_id) ? json_encode($data->friend_requests_id) : "[]";


    $result = $user->create();

    if ($result == 'success') {
        http_response_code(200);
        echo json_encode(array("message" => "success", "code" => "222222"), JSON_UNESCAPED_UNICODE);
        return true;

    } 
    else {
        http_response_code(403);
        echo json_encode(array("message" => $result), JSON_UNESCAPED_UNICODE);
        return false;

    }
}
else {
    http_response_code(403);
    echo json_encode(array("message" => "Empty data"), JSON_UNESCAPED_UNICODE);
}
?>
