<?php
class Event{

    // database connection and table name
    private $conn;
    private $table_name = "events";

    // object properties
    public $id;
    public $localteam_name;
    public $localteam_score;
    public $visitorteam_name;
    public $visitorteam_score;
    public $date;
    public $time;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }


    // read all matches
    function read(){

        // select all query
        $query = "SELECT
                p.id, p.localteam_name, p.localteam_score, p.visitorteam_name, p.visitorteam_score, p.date, p.time
            FROM
                " . $this->table_name . " p
            ORDER BY p.date DESC, p.time DESC";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function readMatchById(){

        // query to read single record
        $query = "SELECT
                 p.id, p.localteam_name, p.localteam_score, p.visitorteam_name, p.visitorteam_score, p.date, p.time
            FROM
                " . $this->table_name . " p
            WHERE
                p.id = ?";

        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // bind id of product to be updated
        $stmt->bindParam(1, $this->id);

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
                localteam_name=:localteam_name,
                localteam_score=:localteam_score,
                visitorteam_name=:visitorteam_name,
                visitorteam_score=:visitorteam_score,
                date=:date,
                time=:time";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->localteam_name=htmlspecialchars(strip_tags($this->localteam_name));
        $this->localteam_score=htmlspecialchars(strip_tags($this->localteam_score));
        $this->visitorteam_name=htmlspecialchars(strip_tags($this->visitorteam_name));
        $this->visitorteam_score=htmlspecialchars(strip_tags($this->visitorteam_score));
        $this->date=htmlspecialchars(strip_tags($this->date));
        $this->time=htmlspecialchars(strip_tags($this->time));

        // bind values
        $stmt->bindParam(":localteam_name", $this->localteam_name);
        $stmt->bindParam(":localteam_score", $this->localteam_score);
        $stmt->bindParam(":visitorteam_name", $this->visitorteam_name);
        $stmt->bindParam(":visitorteam_score", $this->visitorteam_score);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":time", $this->time);

        // execute query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }


    // Update Match
    function update(){

        // update query
        $query = "UPDATE
                " . $this->table_name . "
            SET
                localteam_name=:localteam_name,
                localteam_score=:localteam_score,
                visitorteam_name=:visitorteam_name,
                visitorteam_score=:visitorteam_score,
                date=:date,
                time=:time
                
            WHERE
                id = :id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->localteam_name=htmlspecialchars(strip_tags($this->localteam_name));
        $this->localteam_score=htmlspecialchars(strip_tags($this->localteam_score));
        $this->visitorteam_name=htmlspecialchars(strip_tags($this->visitorteam_name));
        $this->visitorteam_score=htmlspecialchars(strip_tags($this->visitorteam_score));
        $this->date=htmlspecialchars(strip_tags($this->date));
        $this->time=htmlspecialchars(strip_tags($this->time));
        $this->id=htmlspecialchars(strip_tags($this->id));

        // bind values
        $stmt->bindParam(":localteam_name", $this->localteam_name);
        $stmt->bindParam(":localteam_score", $this->localteam_score);
        $stmt->bindParam(":visitorteam_name", $this->visitorteam_name);
        $stmt->bindParam(":visitorteam_score", $this->visitorteam_score);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":time", $this->time);
        $stmt->bindParam(':id', $this->id);

        // execute the query
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


    public function readPaging($from_record_num, $records_per_page){

        // select query
        $query = "SELECT
                p.id, p.localteam_name, p.localteam_score, p.visitorteam_name, p.visitorteam_score, p.date, p.time
            FROM
                " . $this->table_name . " p
            ORDER BY
                p.id DESC
            LIMIT ?, ?";

        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // bind variable values
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

        // execute query
        $stmt->execute();

        // return values from database
        return $stmt;
    }

    public function count(){
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }
}