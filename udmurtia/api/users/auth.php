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
    !empty($data->adminKey) && 
    !empty($data->email) && 
    !empty($data->password) && 
    $data->adminKey == $database->adminKey
    ) {

    $user->email = $data->email;
    $user->password = $data->password;

    if(!$user->isLogin()){

        $result = array('success' => false, 'message' => 'Invalid username or password!');
        echo json_encode($result);
        return false;
        exit();

    }

    if($user->isAdmin() === 'admin'){

        setcookie('AUTH_TOKEN', $database->admin_token, time() + 3600, "/"); 
        $result = array('success' => true, 'message' => 'Successful authorization!');
        echo json_encode($result);

    } else if($user->isAdmin() === 'organizer'){

        setcookie('AUTH_TOKEN', $database->organizer_token, time() + 3600, "/"); 
        $result = array('success' => true, 'message' => 'Successful authorization!');
        echo json_encode($result);

    } else {

        echo json_encode(array("message" => "error"), JSON_UNESCAPED_UNICODE);
        return false;
        exit();

    }
    http_response_code(200);
    return true;
}


if (!empty($data->code) && !empty($data->phone_number)) {

    $user->code = $data->code;
    $user->phone_number = $data->phone_number;

    if(!$user->getNumber()){
        http_response_code(403);
        echo json_encode(array("message" => 'The phone number does not exist'), JSON_UNESCAPED_UNICODE);
        return false;
    }

    if($user->getStatus() != 'confirmed'){
        http_response_code(403);
        echo json_encode(array("message" => 'The status does not correspond to auth'), JSON_UNESCAPED_UNICODE);
        return false;
    }

    $result = $user->getCode();

    if($result != 'not found'){

        if($result != $data->code){
            http_response_code(403);
            echo json_encode(array("message" => "Incorrect code"), JSON_UNESCAPED_UNICODE);
            return false;
        }

        $result = $user->auth();

        if($result != 'error') {
            http_response_code(200);
            echo json_encode(array("message" => "success", "auth_token" => $result), JSON_UNESCAPED_UNICODE);
            return true;
        }
        http_response_code(403);
        echo json_encode(array("message" => $result), JSON_UNESCAPED_UNICODE);
        return false;
    }
    http_response_code(403);
    echo json_encode(array("message" => $result), JSON_UNESCAPED_UNICODE);
    return false;

} 
if (!empty($data->phone_number)) {

    $user->phone_number = $data->phone_number;

    if(!$user->getNumber()){
        http_response_code(403);
        echo json_encode(array("message" => 'The phone number does not exist'), JSON_UNESCAPED_UNICODE);
        return false;
    }

    if($user->getStatus() != 'confirmed'){
        http_response_code(403);
        echo json_encode(array("message" => 'The status does not correspond to auth'), JSON_UNESCAPED_UNICODE);
        return false;
    }

    $user->code = '111111';
    if($user->setCode()) {
        http_response_code(200);
        echo json_encode(array("message" => "success", "code" => '111111'), JSON_UNESCAPED_UNICODE);
        return true;
    }

} 

http_response_code(403);
echo json_encode(array("message" => "Empty data"), JSON_UNESCAPED_UNICODE);

?>