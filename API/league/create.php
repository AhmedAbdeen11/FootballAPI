<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// get database connection
include_once '../config/database.php';

// instantiate league object
include_once '../objects/league.php';

$database = new Database();
$db = $database->getConnection();

$league = new League($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set league property values
$league->league_name = $data->league_name;

// create the league
if($league->create()){

    echo '{';
    echo '"message": "League created."';
    echo '}';
}

// if unable to signup, tell the league
else{
    http_response_code(404);
    echo '{';
    echo '"message": "Failed to create league."';
    echo '}';
}