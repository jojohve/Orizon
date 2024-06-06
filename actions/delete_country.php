<?php
include 'db_connection.php';
include 'modello.php';

$dbConnection = new DBConnection();
$connection = $dbConnection->getConnection();

$countryModel = new Country($connection);
$countryModel->id = $_POST['Id'];

if ($countryModel->deleteCountry()) {
    http_response_code(200);
    echo json_encode(["message" => "Paese eliminato con successo."]);
} else {
    http_response_code(503);
    echo json_encode(["message" => "Impossibile eliminare il paese."]);
}

$dbConnection->closeConnection();
