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

if (
    !empty($data->Id) &&
    !empty($data->Nome_viaggio) &&
    !empty($data->Posti_disponibili) &&
    !empty($data->paesi_ids) &&
    is_array($data->paesi_ids)
) {
    $viaggio->Id = $data->Id;
    $viaggio->Nome_viaggio = $data->Nome_viaggio;
    $viaggio->Posti_disponibili = $data->Posti_disponibili;
    $viaggio->paesi_ids = $data->paesi_ids;

    if ($viaggio->updateTrip()) {
        http_response_code(200);
        echo json_encode(array("message" => "Viaggio aggiornato correttamente."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Impossibile aggiornare il Viaggio."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Impossibile aggiornare il Viaggio, i dati sono incompleti."));
}