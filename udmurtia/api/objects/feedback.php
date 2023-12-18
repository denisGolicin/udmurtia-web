<?php

class Feedback
{
    private $conn;
    private $table_name = "feedback";

    public $id;
    public $email;
    public $title;
    public $phone_number;
    public $message;

    public function __construct($db) { $this->conn = $db; }

    function read()
    {
        $query = "SELECT
            id, email, title, phone_number, message
        FROM
            " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }   

    function create()
    {
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
            email=:email, title=:title, phone_number=:phone_number, message=:message";

        $stmt = $this->conn->prepare($query);

        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));
        $this->message = htmlspecialchars(strip_tags($this->message));

        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":phone_number", $this->phone_number);
        $stmt->bindParam(":message", $this->message);


        return (bool)$stmt->execute();
    }   

}

?>
