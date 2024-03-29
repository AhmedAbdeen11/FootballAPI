<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/match.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();


// initialize object
$match = new Match($db);

// set match property values
$match->id = $_GET['id'];
// query products
$stmt = $match->readMatchById();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // matchs array
    $matches_arr=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $match_data = array(
            "id" => $id,
            "localteam_name" => html_entity_decode($localteam_name),
            "localteam_score" => html_entity_decode($localteam_score),
            "visitorteam_name" => html_entity_decode($visitorteam_name),
            "visitorteam_score" => html_entity_decode($visitorteam_score),
            "date" => $date,
            "time" => $time,
            "league_id" => $league_id
        );

        array_push($matches_arr, $match_data);
    }

//    $response['matches'] = $matches_arr;
    echo json_encode($matches_arr);
}

else{
    echo json_encode(
        array("message" => "No matches found.")
    );
}