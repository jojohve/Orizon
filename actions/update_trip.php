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

$trip = new Trip($db);

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->Id) &&
    !empty($data->trip_name) &&
    !empty($data->availability) &&
    !empty($data->countries_ids) &&
    is_array($data->countries_ids)
) {
    $trip->Id = $data->Id;
    $trip->trip_name = $data->trip_name;
    $trip->availability = $data->availability;
    $trip->countries_ids = $data->countries_ids;

    if ($trip->updateTrip()) {
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