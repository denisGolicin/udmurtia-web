<?php

class News
{
    private $conn;
    private $table_name = "news";

    public $id;
    public $title;
    public $category_id;
    public $description;
    public $category_name;
    public $created;
    public $start_date;
    public $end_date;
    public $start_time;
    public $images;
    public $source_type;
    public $status;
    public $source_link;
    public $event_id;
    public $user_rated;

    public function __construct($db) { $this->conn = $db; }

    function read($limit = 5, $offset = 0)
    {
        $query = "SELECT
            p.id, p.title, p.start_date, p.end_date, p.start_time,
            p.description, p.images, p.source_type, p.status, p.source_link, p.event_id, p.user_rated,
            c.id AS category_id, c.category_name AS category_name
        FROM
            " . $this->table_name . " p
            LEFT JOIN
                category_news c ON p.category_id = c.id
        LIMIT
            :limit OFFSET :offset";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }   

}

?>
