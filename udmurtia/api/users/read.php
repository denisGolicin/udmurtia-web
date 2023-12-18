<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/database.php";
include_once "../objects/users.php";

$database = new Database();
$db = $database->getConnection();


$user = new Users($db);
echo json_encode(array("message" => $user->readFriendsInfo(1)), JSON_UNESCAPED_UNICODE);

?>
