<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// include database and object file
include_once '../config/database.php';
include_once '../objects/match.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
// prepare product object
$match = new Match($db);

// get product id
$data = json_decode(file_get_contents("php://input"));

$match->league_id = $data->league_id;

// delete the product
if($match->deleteAllMatchesByLeagueId()){
    echo '{';
    echo '"message": "Matches deleted."';
    echo '}';
}
// if unable to delete the product
else{
    http_response_code(404);
    echo '{';
    echo '"message": "Unable to delete matches."';
    echo '}';
}