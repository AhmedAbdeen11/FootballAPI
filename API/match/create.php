<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// get database connection
include_once '../config/database.php';

// instantiate match object
include_once '../objects/match.php';

$database = new Database();
$db = $database->getConnection();

$match = new Match($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set match property values
$match->localteam_name = $data->localteam_name;
$match->localteam_score = $data->localteam_score;
$match->visitorteam_name = $data->visitorteam_name;
$match->visitorteam_score = $data->visitorteam_score;
$match->date = $data->date;
$match->time = $data->time;

// create the match
if($match->create()){

    echo '{';
    echo '"message": "Match created."';
    echo '}';
}

// if unable to signup, tell the match
else{
    http_response_code(404);
    echo '{';
    echo '"message": "Failed to create match."';
    echo '}';
}