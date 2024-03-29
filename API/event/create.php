<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// get database connection
include_once '../config/database.php';

// instantiate event object
include_once '../objects/event.php';

$database = new Database();
$db = $database->getConnection();

$event = new Event($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set event property values
$event->type = $data->type;
$event->minute = $data->minute;
$event->team = $data->team;
$event->player = $data->player;
$event->match_id = $data->match_id;

// create the event
if($event->create()){

    echo '{';
    echo '"message": "Event created."';
    echo '}';
}

// if unable to signup, tell the event
else{
    http_response_code(404);
    echo '{';
    echo '"message": "Failed to create event."';
    echo '}';
}