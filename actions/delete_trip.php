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
 
$viaggio = new Trip($db);
 
$data = json_decode(file_get_contents("php://input"));
 
$viaggio->Id = $data->Id;
 
if($viaggio->deleteTrip()){
    http_response_code(200);
    echo json_encode(array("risposta" => "Il Viaggio e' stato eliminato"));
}else{
    http_response_code(503);
    echo json_encode(array("risposta" => "Impossibile eliminare il Viaggio."));
}