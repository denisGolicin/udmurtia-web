<?php
//setcookie($cookie_name, $cookie_value, $expiration_time, "/");

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$data = json_decode(file_get_contents("php://input"));

$token = 'HVtgfvBbUHBiGUfTYnKNnUGuyGUYgJMHUIO';
$login = 'admin@gmail.com';
$password = 'admin123';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if(!isset($_COOKIE["AUTH_TOKEN"])) {
        if($_POST['login'] == $login && $_POST['password'] == $password){

            setcookie('AUTH_TOKEN', $token, time() + 3600, "/"); 
            $result = array('success' => true, 'message' => 'Successful authorization!');
            echo json_encode($result);

            return true;
            exit();

        } else {

            $result = array('success' => false, 'message' => 'Invalid username or password!');
            echo json_encode($result);

            return true;
            exit();
        }
        
    } else {

        $result = array('success' => false, 'message' => 'You authorized! Reload page!');
        echo json_encode($result);

        return false;
        exit();

    }
}


?>