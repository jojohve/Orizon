<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/db_connection.php';
include_once '../models/model.php';

$database = new Database();
$db = $database->getConnection();
$country = new Country($db);
$data = json_decode(file_get_contents("php://input"));
if(
    !empty($data->Id) &&
    !empty($data->country_name)
){
    $country->Id = $data->Id;
    $country->country_name = $data->country_name;
 
    if($country->createCountry()){
        http_response_code(201);
        echo json_encode(array("message" => "Paese creato correttamente."));
    }
    else{
        http_response_code(503);
        echo json_encode(array("message" => "Impossibile creare il Paese."));
    }
}
else{
    http_response_code(400);
    echo json_encode(array("message" => "Impossibile creare il Paese, i dati sono incompleti."));
}