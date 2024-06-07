<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/db_connection.php';
include_once '../models/modello.php';

$database = new Database();
$db = $database->getConnection();
$paese = new Country($db);
$data = json_decode(file_get_contents("php://input"));
if(
    !empty($data->Id) &&
    !empty($data->Nome_paese)
){
    $paese->Id = $data->Id;
    $paese->Nome_paese = $data->Nome_paese;
 
    if($paese->createCountry()){
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