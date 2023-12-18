<?php

class Users
{
    private $conn;
    private $table_name = "users";

    public $id;
    public $first_name;
    public $last_name;
    public $middle_name;
    public $birth_date;
    public $email;
    public $password;
    public $phone_number;
    public $mailing_address;
    public $event_ids;
    public $profile_photo;
    public $certificate_photos;
    public $residence_location;
    public $age;
    public $gender;
    public $status;
    public $user_type;
    public $balance;
    public $code;
    public $auth_token;
    public $friend_ids;
    public $friend_requests_id;

    public function __construct($db) { $this->conn = $db; }

    function read()
    {
        $query = "SELECT
            id, first_name, last_name, middle_name, birth_date,
            email, phone_number, mailing_address, event_ids, profile_photo,
            certificate_photos, residence_location, age, gender, status,
            user_type, balance
        FROM
            " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }   
    function create()
    {   
        $this->conn->beginTransaction(); 

        $check_email_query = "SELECT id FROM " . $this->table_name . " WHERE email = :email";
        $check_email_stmt = $this->conn->prepare($check_email_query);
        $check_email_stmt->bindParam(":email", $this->email);
        $check_email_stmt->execute();

        if (!empty($this->phone_number)) {
            $check_phone_query = "SELECT id FROM " . $this->table_name . " WHERE phone_number = :phone_number";
            $check_phone_stmt = $this->conn->prepare($check_phone_query);
            $check_phone_stmt->bindParam(":phone_number", $this->phone_number);
            $check_phone_stmt->execute();
        }

        if ($check_email_stmt->rowCount() > 0 || (!empty($this->phone_number) && $check_phone_stmt->rowCount() > 0)) {
            if ($check_email_stmt->rowCount() > 0) {
                return 'Email already exists';
            } elseif (!empty($this->phone_number) && $check_phone_stmt->rowCount() > 0) {
                return 'Phone number already exists';
            }
            $this->conn->rollback(); 
        }


        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                first_name=:first_name, last_name=:last_name, middle_name=:middle_name, 
                birth_date=:birth_date, email=:email, password=:password, mailing_address=:mailing_address,
                event_ids=:event_ids, profile_photo=:profile_photo, certificate_photos=:certificate_photos, 
                residence_location=:residence_location, age=:age, gender=:gender, status=:status, 
                user_type=:user_type, balance=:balance, phone_number=:phone_number, auth_token=:auth_token, code=:code, 
                friends_ids=:friends_ids, friend_requests_id=:friend_requests_id";

        $stmt = $this->conn->prepare($query); 

        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->middle_name = htmlspecialchars(strip_tags($this->middle_name));
        $this->birth_date = htmlspecialchars(strip_tags($this->birth_date));
        //$this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->mailing_address = htmlspecialchars(strip_tags($this->mailing_address));
        $this->event_ids = htmlspecialchars(strip_tags($this->event_ids));
        $this->profile_photo = htmlspecialchars(strip_tags($this->profile_photo));
        $this->certificate_photos = htmlspecialchars(strip_tags($this->certificate_photos));
        $this->residence_location = htmlspecialchars(strip_tags($this->residence_location));
        $this->age = htmlspecialchars(strip_tags($this->age));
        $this->gender = htmlspecialchars(strip_tags($this->gender));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->user_type = htmlspecialchars(strip_tags($this->user_type));
        $this->balance = htmlspecialchars(strip_tags($this->balance));
        $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));
        $this->auth_token = htmlspecialchars(strip_tags($this->auth_token));
        $this->code = htmlspecialchars(strip_tags($this->code));
        $this->friends_ids = htmlspecialchars(strip_tags($this->friends_ids));
        $this->friend_requests_id = htmlspecialchars(strip_tags($this->friend_requests_id));

        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":middle_name", $this->middle_name);
        $stmt->bindParam(":birth_date", $this->birth_date);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":mailing_address", $this->mailing_address);
        $stmt->bindParam(":event_ids", $this->event_ids);
        $stmt->bindParam(":profile_photo", $this->profile_photo);
        $stmt->bindParam(":certificate_photos", $this->certificate_photos);
        $stmt->bindParam(":residence_location", $this->residence_location);
        $stmt->bindParam(":age", $this->age);
        $stmt->bindParam(":gender", $this->gender);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":user_type", $this->user_type);
        $stmt->bindParam(":balance", $this->balance);
        $stmt->bindParam(":phone_number", $this->phone_number);
        $stmt->bindParam(":auth_token", $this->auth_token);
        $stmt->bindParam(":code", $this->code);
        $stmt->bindParam(":friends_ids", $this->friends_ids);
        $stmt->bindParam(":friend_requests_id", $this->friend_requests_id);

        if ($stmt->execute()) {
            $this->conn->commit(); 
            return 'success';
        } else {
            $errorInfo = $stmt->errorInfo(); 
            $this->conn->rollback(); 
            return "error: " . $errorInfo[2];
        }

    }

    
    function getNumber(){
        $phonePattern = '/^\+7-\d{3}-\d{3}-\d{2}-\d{2}$/';
        if (!preg_match($phonePattern, $this->phone_number)) return 'format';

        $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));

        $query = "SELECT id FROM users WHERE phone_number = :phone_number";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":phone_number", $this->phone_number);
        $stmt->execute();

        return (bool)($stmt->rowCount() > 0);
   }

   function getCode(){

        $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));

        $query = "SELECT code FROM users WHERE phone_number = :phone_number";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":phone_number", $this->phone_number);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $stored_code = $row['code'];

            return $stored_code;
        } else {
            return 'Number not found!';
        }
    }

    function getToken(){
        $this->auth_token = htmlspecialchars(strip_tags($this->auth_token));

        $query = "SELECT id FROM users WHERE auth_token = :auth_token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":auth_token", $this->auth_token);
        $stmt->execute();

        return (bool)($stmt->rowCount() > 0);
    }

   function setCode(){

        $query = "UPDATE " . $this->table_name . " SET code=:code WHERE phone_number=:phone_number";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":code", $this->code);
        $stmt->bindParam(":phone_number", $this->phone_number);

        return (bool)$stmt->execute();
    }

    function getStatus() {
        $query = "SELECT status FROM " . $this->table_name . " WHERE phone_number = :phone_number";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":phone_number", $this->phone_number);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $result['status'] ?? null;
    }

    function updateStatus() {
        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE phone_number = :phone_number";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":phone_number", $this->phone_number);

        return (bool)$stmt->execute();
    }

    function isAdmin() {
        $query = "SELECT CASE
             WHEN user_type = 'admin' THEN 'admin'
             WHEN user_type = 'organizer' THEN 'organizer'
             ELSE 'error'
           END AS is_admin
           FROM " . $this->table_name . " WHERE email = :email";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($result) {
            return $result['is_admin']; 
        } else {
            return false; 
        }
    }

    function isLogin(){
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password)); 
    
        
        $query = "SELECT password FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();
    
        
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $stored_password = $row['password'];
    
            if ($this->password === $stored_password) {
                return true;
            } else {
                return false; 
            }
        } else {
            return false;
        }
    }

    function readFriendsInfo($user_id)
    {
        $query = "SELECT friends_ids FROM " . $this->table_name . " WHERE id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id); 
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $friends_ids = json_decode($row['friends_ids'], true);

        if (is_array($friends_ids) && !empty($friends_ids)) {
            $friend_ids_string = implode(",", $friends_ids);

            $query = "SELECT id, first_name, last_name, profile_photo FROM " . $this->table_name . " WHERE id IN ($friend_ids_string)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            $friends_info = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $friend_info = array(
                    "id" => $row['id'],
                    "first_name" => $row['first_name'],
                    "last_name" => $row['last_name'],
                    "profile_photo" => $row['profile_photo']
                );
                array_push($friends_info, $friend_info);
            }

            return $friends_info;
        }

        return array(); 
    }


    
    

    function auth(){
        $token = generateRandomToken();
        $query = "UPDATE " . $this->table_name . " SET auth_token=:auth_token WHERE phone_number=:phone_number";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":auth_token", $token);
        $stmt->bindParam(":phone_number", $this->phone_number);

        if ($stmt->execute()) {
            return $token;
        } else {
            return 'Error request';
        }
    }

    function register(){
        
        $query = "UPDATE " . $this->table_name . " SET first_name=:first_name, last_name=:last_name, birth_date=:birth_date, status = :status WHERE phone_number=:phone_number";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":phone_number", $this->phone_number);
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":birth_date", $this->birth_date);
        $stmt->bindParam(":status", $this->status);

        return (bool)$stmt->execute();
    }

}

function generateRandomToken($length = 24) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $token = '';
    
    for ($i = 0; $i < $length; $i++) {
        $token .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    return $token;
}

?>
