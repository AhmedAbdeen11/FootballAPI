<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/match.php';
include_once '../objects/event.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();


// initialize object
$match = new Match($db);

$match->league_id = $_GET['comp_id'];
$match ->date = $_GET['date'];

// query products
$stmt1 = $match->readMatchesByDateAndCompId();
$num1 = $stmt1->rowCount();

// check if more than 0 record found
if($num1>0){

    // matchs array
    $matchs_arr=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row1);

        //----------Read Match Events------------//
        $event = new Event($db);
        $event->match_id = $match_id;

        // query events
        $stmt2 = $event->readEventsByMatchId();
        $num2 = $stmt2->rowCount();
        // check if more than 0 record found

        // events array
        $events_arr=array();

        if($num2>0){

            // retrieve our table contents
            // fetch() is faster than fetchAll()
            // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
            while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
                // extract row
                // this will make $row['name'] to
                // just $name only
                extract($row2);

                $event_data = array(
                    "id" => $id,
                    "type" => html_entity_decode($type),
                    "minute" => html_entity_decode($minute),
                    "team" => html_entity_decode($team),
                    "player" => html_entity_decode($player),
                    "assist" => $assist);

                array_push($events_arr, $event_data);
            }
        }


        $match_data = array(
            "id" => $match_id,
            "localteam_name" => html_entity_decode($localteam_name),
            "localteam_score" => html_entity_decode($localteam_score),
            "visitorteam_name" => html_entity_decode($visitorteam_name),
            "visitorteam_score" => html_entity_decode($visitorteam_score),
            "formatted_date" => $formatted_date,
            "time" => $time,
            "events" => $events_arr
        );

        array_push($matchs_arr, $match_data);
    }

    echo json_encode($matchs_arr);
}

else{
    echo '{';
    echo '"message": "No Matches Found"';
    echo '}';
}