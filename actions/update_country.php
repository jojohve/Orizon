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

$paese = new Country($db);

$data = json_decode(file_get_contents("php://input"));

$paese->Id = $data->Id;
$paese->Nome_paese = $data->Nome_paese;

if ($paese->updateCountry()) {
    http_response_code(200);
    echo json_encode(array("risposta" => "Paese aggiornato"));
} else {
    http_response_code(503);
    echo json_encode(array("risposta" => "Impossibile aggiornare il Paese"));
}
?>