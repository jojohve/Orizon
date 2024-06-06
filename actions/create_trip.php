<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'db_connection.php';
include_once 'modello.php';

$database = new Database();
$db = $database->getConnection();
$viaggio = new Trip($db);
$data = json_decode(file_get_contents("php://input"));
if(
    !empty($data->Id) &&
    !empty($data->Nome_viaggio) &&
    !empty($data->Posti_disponibili)
){
    $viaggio->Id = $data->Id;
    $viaggio->Nome_viaggio = $data->Nome_viaggio;
    $viaggio->Posti_disponibili = $data->Posti_disponibili;
 
    if($viaggio->createTrip()){
        http_response_code(201);
        echo json_encode(array("message" => "Viaggio creato correttamente."));
    }
    else{
        http_response_code(503);
        echo json_encode(array("message" => "Impossibile creare il Viaggio."));
    }
}
else{
    http_response_code(400);
    echo json_encode(array("message" => "Impossibile creare il Viaggio, i dati sono incompleti."));
}