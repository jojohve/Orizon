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
 
$paese->Id = $data->Id;
 
if($paese->deleteCountry()){
    http_response_code(200);
    echo json_encode(array("risposta" => "Il Paese e' stato eliminato"));
}else{
    http_response_code(503);
    echo json_encode(array("risposta" => "Impossibile eliminare il Paese."));
}