<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/event.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();


// initialize object
$event = new Event($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set event property values
$event->match_id = $data->match_id;

// query events
$stmt = $event->readEventsByMatchId();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // events array
    $events_arr=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $team_formatted_name = "";
        if($team == "localteam"){
            $team_formatted_name = $localteam_name;

        }else if($team == "visitorteam"){
            $team_formatted_name = $visitorteam_name;
        }else{
            // No Action
        }

        $event_data = array(
            "id" => $id,
            "type" => html_entity_decode($type),
            "minute" => html_entity_decode($minute),
            "team" => html_entity_decode($team_formatted_name),
            "player" => html_entity_decode($player),
            "assist" => $assist,
            "match_id" => $match_id);

        array_push($events_arr, $event_data);
    }

    $response['events'] = $events_arr;
    echo json_encode($response);
}

else{
    echo json_encode(
        array("message" => "No events found.")
    );
}