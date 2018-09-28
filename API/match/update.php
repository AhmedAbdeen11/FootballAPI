<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// get database connection
include_once '../config/database.php';

// instantiate analytics object
include_once '../objects/match.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set match property values
$user->id = $data->id;
$user->name = $data->name;
$user->img = $data->img;
$user->type = $data->type;

// create the analytics
if($user->update()){
    echo '{';
    echo '"message": "User Updated."';
    echo '}';
}

// if unable to signup, tell the analytics
else{
    http_response_code(404);
    echo '{';
    echo '"message": "Failed to update match."';
    echo '}';
}