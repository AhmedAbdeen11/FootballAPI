<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/league.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();


// initialize object
$league = new League($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

$league->id = $data->id;

// query products
$stmt = $league->readLeagueName();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // leagues array
    $leagues_arr=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
        echo $league_name;

        /*$league_data = array(
            "id" => $id,
            "league_name" => html_entity_decode($league_name)
        );

        array_push($leagues_arr, $league_data);*/
    }

    /*$response['leagues'] = $leagues_arr;
    echo json_encode($response);*/
}

else{
    echo json_encode(
        array("message" => "No leagues found.")
    );
}