<?php
class Event{

    // database connection and table name
    private $conn;
    private $table_name = "events";

    // object properties
    public $id;
    public $type;
    public $minute;
    public $team;
    public $player;
    public $match_id;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }


    function readEventsByMatchId(){

        // query to read single record
        $query = "SELECT
                 p.id, p.type, p.minute, p.team, p.player, p.match_id, m.localteam_name, m.visitorteam_name
            FROM
                " . $this->table_name . " p
            LEFT JOIN
                matches m
            ON
                p.match_id = m.id
            WHERE
                p.match_id = ?
            ORDER BY
                p.minute ASC";

        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // bind id of product to be updated
        $stmt->bindParam(1, $this->match_id);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // create event
    function create(){

        // query to insert record
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                type=:type,
                minute=:minute,
                team=:team,
                player=:player,
                match_id=:match_id";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->type=htmlspecialchars(strip_tags($this->type));
        $this->minute=htmlspecialchars(strip_tags($this->minute));
        $this->team=htmlspecialchars(strip_tags($this->team));
        $this->player=htmlspecialchars(strip_tags($this->player));
        $this->match_id=htmlspecialchars(strip_tags($this->match_id));

        // bind values
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":minute", $this->minute);
        $stmt->bindParam(":team", $this->team);
        $stmt->bindParam(":player", $this->player);
        $stmt->bindParam(":match_id", $this->match_id);

        // execute query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    // Update Event
    function update(){

        // update query
        $query = "UPDATE
                " . $this->table_name . "
            SET
                type=:type,
                minute=:minute,
                team=:team,
                player=:player                
            WHERE
                id = :id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->type=htmlspecialchars(strip_tags($this->type));
        $this->minute=htmlspecialchars(strip_tags($this->minute));
        $this->team=htmlspecialchars(strip_tags($this->team));
        $this->player=htmlspecialchars(strip_tags($this->player));
        $this->id=htmlspecialchars(strip_tags($this->id));

        // bind values
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":minute", $this->minute);
        $stmt->bindParam(":team", $this->team);
        $stmt->bindParam(":player", $this->player);
        $stmt->bindParam(':id', $this->id);

        // execute the query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    function readEventById(){

        // query to read single record
        $query = "SELECT
                 p.id, p.type, p.minute, p.team, p.player, p.match_id
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

    // delete event
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