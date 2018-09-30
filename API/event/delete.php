<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// include database and object file
include_once '../config/database.php';
include_once '../objects/event.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
// prepare event object
$event = new Event($db);

// get Event id
$data = json_decode(file_get_contents("php://input"));

$event->id = $data->id;

// delete the event
if($event->delete()){
    echo '{';
    echo '"message": "Event deleted."';
    echo '}';
}
// if unable to delete the product
else{
    http_response_code(404);
    echo '{';
    echo '"message": "Unable to delete event."';
    echo '}';
}