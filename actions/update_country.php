<?php
include 'db_connection.php';
include 'modello.php';

$dbConnection = new DBConnection();
$connection = $dbConnection->getConnection();

$countryModel = new Country($connection);
$countryModel->id = $_POST['Id'];
$countryModel->nome_paese = $_POST['Nome_paese'];

if ($countryModel->updateCountry()) {
    http_response_code(200);
    echo json_encode(["message" => "Paese aggiornato con successo."]);
} else {
    http_response_code(503);
    echo json_encode(["message" => "Impossibile aggiornare il paese."]);
}

$dbConnection->closeConnection();
