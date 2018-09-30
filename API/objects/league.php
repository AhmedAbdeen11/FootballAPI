<?php
class League{

    // database connection and table name
    private $conn;
    private $table_name = "leagues";

    // object properties
    public $id;
    public $league_name;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }


    // read all matches
    function read(){

        // select all query
        $query = "SELECT
                p.id, p.league_name
            FROM
                " . $this->table_name . " p";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // create match
    function create(){

        // query to insert record
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                league_name=:league_name";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->league_name=htmlspecialchars(strip_tags($this->league_name));

        // bind values
        $stmt->bindParam(":league_name", $this->league_name);

        // execute query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    // delete match
    function delete(){

        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));

        // bind id of record to delete
        $stmt->bindParam(1, $this->id);

        // execute query
        if($stmt->execute()){
            return true;
        }id:

        return false;
    }

    public function count(){
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }
}